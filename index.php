<?php
/**
 * Yandex Cloud Functions handler для страницы со списком задач.
 * Состояние чекбоксов хранится в Yandex Object Storage (один JSON-объект),
 * поэтому одинаково доступно с любого устройства.
 *
 * Архив для деплоя должен содержать:
 *   index.php
 *   page-template.php
 *
 * Настройки функции:
 *   Точка входа:        index.handler
 *   Сервисный аккаунт:  с ролью storage.editor на бакет (или каталог)
 *   Переменные окружения:
 *     BUCKET_NAME  (обязательно) — имя бакета
 *     STATE_KEY    (необязательно) — ключ объекта, по умолчанию tasks_state.json
 *
 * Аутентификация в Object Storage идёт по IAM-токену сервисного аккаунта
 * функции, статические ключи не нужны.
 */

const S3_ENDPOINT = 'https://storage.yandexcloud.net';

function handler($event, $context)
{
    $method = strtoupper(
        $event['httpMethod']
        ?? ($event['requestContext']['http']['method'] ?? 'GET')
    );

    $bucket = getenv('BUCKET_NAME') ?: '';
    $key    = getenv('STATE_KEY') ?: 'tasks_state.json';
    $token  = getIamToken($context);

    if ($bucket === '' || $token === null) {
        error_log('Config error: BUCKET_NAME is empty or function has no service account');
        return jsonResponse(500, [
            'status'  => 'error',
            'message' => 'Storage is not configured (BUCKET_NAME / service account)',
        ]);
    }

    $query  = $event['queryStringParameters'] ?? [];
    $isApi  = is_array($query) && (($query['api'] ?? '') === 'state');

    // ---------- POST: слияние изменённых чекбоксов с состоянием в бакете ----------
    if ($method === 'POST') {
        $body = $event['body'] ?? '';
        if (!empty($event['isBase64Encoded'])) {
            $body = base64_decode($body, true);
            if ($body === false) {
                $body = '';
            }
        }

        $changes = json_decode($body, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($changes) || count($changes) > 500) {
            return jsonResponse(400, ['status' => 'error', 'message' => 'Invalid JSON']);
        }

        $clean = [];
        foreach ($changes as $id => $checked) {
            if (!is_string($id) || !preg_match('/^[A-Za-z0-9_-]{1,64}$/', $id) || !is_bool($checked)) {
                return jsonResponse(400, ['status' => 'error', 'message' => 'Invalid state format']);
            }
            $clean[$id] = $checked;
        }

        try {
            // Читаем актуальное состояние и меняем только пришедшие ключи,
            // чтобы устаревшая вкладка не затирала отметки с другого устройства.
            $state = loadState($bucket, $key, $token);
            $state = array_merge($state, $clean);
            saveState($bucket, $key, $token, $state);
        } catch (Throwable $e) {
            error_log('Storage error (POST): ' . $e->getMessage());
            return jsonResponse(502, ['status' => 'error', 'message' => 'Storage unavailable']);
        }

        return jsonResponse(200, ['status' => 'success']);
    }

    if ($method !== 'GET') {
        return jsonResponse(405, ['status' => 'error', 'message' => 'Method not allowed'], ['Allow' => 'GET, POST']);
    }

    // ---------- GET ----------
    $storageError = false;
    $state = [];
    try {
        $state = loadState($bucket, $key, $token);
    } catch (Throwable $e) {
        error_log('Storage error (GET): ' . $e->getMessage());
        $storageError = true;
        if ($isApi) {
            return jsonResponse(502, ['status' => 'error', 'message' => 'Storage unavailable']);
        }
    }

    // JSON-эндпоинт: страница обновляет отметки при возврате на вкладку
    if ($isApi) {
        return jsonResponse(200, $state === [] ? new stdClass() : $state);
    }

    $GLOBALS['TASKS_INITIAL_STATE'] = $state;
    $GLOBALS['TASKS_STORAGE_ERROR'] = $storageError;

    ob_start();
    include __DIR__ . '/page-template.php';
    $html = ob_get_clean();

    return [
        'statusCode' => 200,
        'headers' => [
            'Content-Type'  => 'text/html; charset=utf-8',
            'Cache-Control' => 'no-store',
        ],
        'isBase64Encoded' => false,
        'body' => $html,
    ];
}

/* ------------------------------------------------------------------------ */
/* Вспомогательные функции                                                   */
/* ------------------------------------------------------------------------ */

function jsonResponse(int $status, $data, array $extraHeaders = []): array
{
    return [
        'statusCode' => $status,
        'headers' => array_merge([
            'Content-Type'  => 'application/json; charset=utf-8',
            'Cache-Control' => 'no-store',
        ], $extraHeaders),
        'isBase64Encoded' => false,
        'body' => json_encode($data, JSON_UNESCAPED_UNICODE),
    ];
}

/** IAM-токен сервисного аккаунта, привязанного к функции. */
function getIamToken($context): ?string
{
    if (is_object($context) && method_exists($context, 'getToken')) {
        $token = $context->getToken();
        if (is_object($token) && method_exists($token, 'getAccessToken')) {
            $value = $token->getAccessToken();
            return $value !== '' ? $value : null;
        }
    }

    // На случай, если runtime передаёт контекст массивом
    if (is_array($context) && !empty($context['token']['access_token'])) {
        return $context['token']['access_token'];
    }

    return null;
}

function objectUrl(string $bucket, string $key): string
{
    // Path-style URL работает и для бакетов с точками в имени
    return S3_ENDPOINT . '/' . rawurlencode($bucket) . '/'
        . str_replace('%2F', '/', rawurlencode($key));
}

/**
 * Читает состояние из бакета. Если объекта ещё нет — возвращает [].
 * При любой другой ошибке бросает исключение (чтобы не затереть данные пустым состоянием).
 */
function loadState(string $bucket, string $key, string $token): array
{
    [$status, $body] = httpRequest('GET', objectUrl($bucket, $key), $token);

    if ($status === 404) {
        return [];
    }
    if ($status !== 200) {
        throw new RuntimeException("GET object failed, HTTP $status: " . substr($body, 0, 300));
    }

    $decoded = json_decode($body, true);
    return is_array($decoded) ? $decoded : [];
}

function saveState(string $bucket, string $key, string $token, array $state): void
{
    $json = json_encode($state, JSON_UNESCAPED_UNICODE);
    [$status, $body] = httpRequest('PUT', objectUrl($bucket, $key), $token, $json);

    if ($status < 200 || $status >= 300) {
        throw new RuntimeException("PUT object failed, HTTP $status: " . substr($body, 0, 300));
    }
}

/** HTTP-запрос с Bearer IAM-токеном. Возвращает [код ответа, тело]. */
function httpRequest(string $method, string $url, string $token, ?string $body = null): array
{
    $headers = ['Authorization: Bearer ' . $token];
    if ($body !== null) {
        $headers[] = 'Content-Type: application/json; charset=utf-8';
    }

    if (function_exists('curl_init')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_CUSTOMREQUEST  => $method,
            CURLOPT_HTTPHEADER     => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT        => 10,
        ]);
        if ($body !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        }

        $response = curl_exec($ch);
        if ($response === false) {
            $err = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException('cURL error: ' . $err);
        }
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return [$status, (string)$response];
    }

    // Запасной вариант, если расширение curl недоступно
    $opts = [
        'http' => [
            'method'        => $method,
            'header'        => implode("\r\n", $headers),
            'timeout'       => 10,
            'ignore_errors' => true,
        ],
    ];
    if ($body !== null) {
        $opts['http']['content'] = $body;
    }

    $response = @file_get_contents($url, false, stream_context_create($opts));
    if ($response === false) {
        throw new RuntimeException('HTTP request failed (stream wrapper)');
    }

    $status = 0;
    foreach (($http_response_header ?? []) as $line) {
        if (preg_match('#^HTTP/\S+\s+(\d{3})#', $line, $m)) {
            $status = (int)$m[1]; // последний заголовок статуса (после редиректов)
        }
    }

    return [$status, $response];
}
