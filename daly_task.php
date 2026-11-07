<?php
// Путь к файлу, в котором будем хранить состояния
$storageFile = 'tasks_state.json';

// Если это POST-запрос, значит мы сохраняем данные
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents('php://input');
    if ($json) {
        file_put_contents($storageFile, $json);
        echo json_encode(['status' => 'success']);
        exit;
    }
}

// Если это GET-запрос, читаем данные для инициализации
$initialState = '{}';
if (file_exists($storageFile)) {
    $initialState = file_get_contents($storageFile);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список задач (Серверное хранение)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .task-checkbox:checked + .task-text,
        .task-checkbox:checked + .task-link .task-text,
        .task-checkbox:checked ~ .task-content .task-text {
            text-decoration: line-through;
            color: #9ca3af;
        }
        .task-checkbox:checked ~ .task-content .task-description {
            color: #d1d5db;
            text-decoration: line-through;
        }
        /* Индикатор синхронизации */
        #sync-status { transition: opacity 0.3s; opacity: 0; }
        #sync-status.show { opacity: 1; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-2xl shadow-xl overflow-hidden relative">
        <div class="bg-indigo-600 p-6">
            <h1 class="text-white text-2xl font-bold flex items-center gap-2">Мои задачи</h1>
            <div class="flex justify-between items-center mt-1">
                <p class="text-indigo-200 text-xs">Данные в файле на сервере</p>
                <span id="sync-status" class="text-white text-[10px] bg-indigo-500 px-2 py-0.5 rounded">Сохранено</span>
            </div>
        </div>

<!-- Список задач -->
        <div class="p-6">
            <div id="todo-container" class="space-y-6 mb-8">
                
                <!-- Группа 1: Работа -->
                <section>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-3">Утром:</h2>
                    <ul class="space-y-1">
                        <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">В едадил</span>
                        </li>
                        <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Тиньков кешбек (мой)</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Тиньков кешбек (отец)</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Тиньков кешбек (мамин)</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Тиньков кешбек (сашкин)</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Помыть рожу и намазать кремом</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Миноксидил</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Протеин</span>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <a href="pepper.ru/new" target="_blank" class="task-link flex-grow group">
                                <span class="task-text text-indigo-600 group-hover:text-indigo-800 text-lg select-none cursor-pointer none  decoration-dotted">Pepper</span>
                            </a>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <a href="pepper.ru/new" target="_blank" class="task-link flex-grow group">
                                <span class="task-text text-indigo-600 group-hover:text-indigo-800 text-lg select-none cursor-pointer none  decoration-dotted">Телеграм (папка Банки, Новости)</span>
                            </a>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <a href="https://www.aviasales.ru/?params=MOWAER1" target="_blank" class="task-link flex-grow group">
                                <span class="task-text text-indigo-600 group-hover:text-indigo-800 text-lg select-none cursor-pointer none  decoration-dotted">Билеты в сочи</span>
                            </a>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <a href="https://www.aviasales.ru/map?center=40.247,43.344&params=MOW1&zoom=8.81" target="_blank" class="task-link flex-grow group">
                                <span class="task-text text-indigo-600 group-hover:text-indigo-800 text-lg select-none cursor-pointer none  decoration-dotted">Билеты куда угодно</span>
                            </a>
                        </li>
						
                    </ul>
                </section>

                <!-- Группа 2: Личное -->
                <section>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-3">Вечером:</h2>
                    <ul class="space-y-1">
                        <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Финастерид</span>
                        </li>
                        <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Протеин</span>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Минокседил</span>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Протеин</span>
                        </li>
						<li class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox mt-1.5 w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <div class="task-content flex flex-col flex-grow">
                               <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Помыть и намазать рожу:</span>
                                <!-- Описание мелким шрифтом -->
                                <p class="task-description text-sm text-gray-500 select-none cursor-default">
								<b>Понедельник</b> - BHA</br>
								<b>Вторник</b> - Mixit</br>
								<b>Среда</b> - Ретиноид</br>
								<b>Четверг</b> - Mixit</br>
								<b>Пятница</b> - BHA</br>
								<b>Суббота</b> - Глина</br>
								<b>Воскресенье</b> - Ретиноид и дермапен (без миноксидила)</p>
                            </div>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Меню на завтра</span>
                        </li>
                    </ul>
                </section>

            </div>

            <!-- Кнопка управления -->
            <button id="toggle-all" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-xl shadow-md transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                <span id="btn-text">Отметить все как выполненные</span>
            </button>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('toggle-all');
        const syncLabel = document.getElementById('sync-status');
        
        // Получаем начальное состояние из PHP
        const initialState = <?php echo $initialState; ?>;

        // Сохранение на сервер через fetch
        const saveToServer = async () => {
            const state = {};
            document.querySelectorAll('.task-checkbox').forEach(cb => {
                state[cb.dataset.id] = cb.checked;
            });

            try {
                await fetch(window.location.href, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(state)
                });
                showSyncBadge();
            } catch (e) {
                console.error("Ошибка сохранения:", e);
            }
        };

        const showSyncBadge = () => {
            syncLabel.classList.add('show');
            setTimeout(() => syncLabel.classList.remove('show'), 2000);
        };

        const updateButtonUI = () => {
            const checkboxes = document.querySelectorAll('.task-checkbox');
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const allChecked = checkedCount === checkboxes.length && checkboxes.length > 0;
            document.getElementById('btn-text').textContent = allChecked ? 'Снять все' : 'Отметить все';
        };

        toggleBtn.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.task-checkbox');
            const newState = !Array.from(checkboxes).every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = newState);
            updateButtonUI();
            saveToServer();
        });

        document.addEventListener('change', (e) => {
            if (e.target.classList.contains('task-checkbox')) {
                updateButtonUI();
                saveToServer();
            }
        });

        // Клик по тексту
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('task-text')) {
                const cb = e.target.closest('li').querySelector('.task-checkbox');
                cb.checked = !cb.checked;
                updateButtonUI();
                saveToServer();
            }
        });

        // Загрузка данных при старте
        window.onload = () => {
            Object.keys(initialState).forEach(id => {
                const cb = document.querySelector(`[data-id="${id}"]`);
                if (cb) cb.checked = initialState[id];
            });
            updateButtonUI();
        };
    </script>
</body>
</html>