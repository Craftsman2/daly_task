<?php
// State passed by index.php handler.
$initialState = $GLOBALS['TASKS_INITIAL_STATE'] ?? [];
$storageError = !empty($GLOBALS['TASKS_STORAGE_ERROR']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список задач (Серверное хранение)</title>
    <!-- Tailwind CSS 3.4.17, собран локально (только используемые классы) -->
    <style>*,:after,:before{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgba(59,130,246,.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }::backdrop{--tw-border-spacing-x:0;--tw-border-spacing-y:0;--tw-translate-x:0;--tw-translate-y:0;--tw-rotate:0;--tw-skew-x:0;--tw-skew-y:0;--tw-scale-x:1;--tw-scale-y:1;--tw-pan-x: ;--tw-pan-y: ;--tw-pinch-zoom: ;--tw-scroll-snap-strictness:proximity;--tw-gradient-from-position: ;--tw-gradient-via-position: ;--tw-gradient-to-position: ;--tw-ordinal: ;--tw-slashed-zero: ;--tw-numeric-figure: ;--tw-numeric-spacing: ;--tw-numeric-fraction: ;--tw-ring-inset: ;--tw-ring-offset-width:0px;--tw-ring-offset-color:#fff;--tw-ring-color:rgba(59,130,246,.5);--tw-ring-offset-shadow:0 0 #0000;--tw-ring-shadow:0 0 #0000;--tw-shadow:0 0 #0000;--tw-shadow-colored:0 0 #0000;--tw-blur: ;--tw-brightness: ;--tw-contrast: ;--tw-grayscale: ;--tw-hue-rotate: ;--tw-invert: ;--tw-saturate: ;--tw-sepia: ;--tw-drop-shadow: ;--tw-backdrop-blur: ;--tw-backdrop-brightness: ;--tw-backdrop-contrast: ;--tw-backdrop-grayscale: ;--tw-backdrop-hue-rotate: ;--tw-backdrop-invert: ;--tw-backdrop-opacity: ;--tw-backdrop-saturate: ;--tw-backdrop-sepia: ;--tw-contain-size: ;--tw-contain-layout: ;--tw-contain-paint: ;--tw-contain-style: }/*! tailwindcss v3.4.17 | MIT License | https://tailwindcss.com*/*,:after,:before{box-sizing:border-box;border:0 solid #e5e7eb}:after,:before{--tw-content:""}:host,html{line-height:1.5;-webkit-text-size-adjust:100%;-moz-tab-size:4;-o-tab-size:4;tab-size:4;font-family:ui-sans-serif,system-ui,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;font-feature-settings:normal;font-variation-settings:normal;-webkit-tap-highlight-color:transparent}body{margin:0;line-height:inherit}hr{height:0;color:inherit;border-top-width:1px}abbr:where([title]){-webkit-text-decoration:underline dotted;text-decoration:underline dotted}h1,h2,h3,h4,h5,h6{font-size:inherit;font-weight:inherit}a{color:inherit;text-decoration:inherit}b,strong{font-weight:bolder}code,kbd,pre,samp{font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,Liberation Mono,Courier New,monospace;font-feature-settings:normal;font-variation-settings:normal;font-size:1em}small{font-size:80%}sub,sup{font-size:75%;line-height:0;position:relative;vertical-align:baseline}sub{bottom:-.25em}sup{top:-.5em}table{text-indent:0;border-color:inherit;border-collapse:collapse}button,input,optgroup,select,textarea{font-family:inherit;font-feature-settings:inherit;font-variation-settings:inherit;font-size:100%;font-weight:inherit;line-height:inherit;letter-spacing:inherit;color:inherit;margin:0;padding:0}button,select{text-transform:none}button,input:where([type=button]),input:where([type=reset]),input:where([type=submit]){-webkit-appearance:button;background-color:transparent;background-image:none}:-moz-focusring{outline:auto}:-moz-ui-invalid{box-shadow:none}progress{vertical-align:baseline}::-webkit-inner-spin-button,::-webkit-outer-spin-button{height:auto}[type=search]{-webkit-appearance:textfield;outline-offset:-2px}::-webkit-search-decoration{-webkit-appearance:none}::-webkit-file-upload-button{-webkit-appearance:button;font:inherit}summary{display:list-item}blockquote,dd,dl,figure,h1,h2,h3,h4,h5,h6,hr,p,pre{margin:0}fieldset{margin:0}fieldset,legend{padding:0}menu,ol,ul{list-style:none;margin:0;padding:0}dialog{padding:0}textarea{resize:vertical}input::-moz-placeholder,textarea::-moz-placeholder{opacity:1;color:#9ca3af}input::placeholder,textarea::placeholder{opacity:1;color:#9ca3af}[role=button],button{cursor:pointer}:disabled{cursor:default}audio,canvas,embed,iframe,img,object,svg,video{display:block;vertical-align:middle}img,video{max-width:100%;height:auto}[hidden]:where(:not([hidden=until-found])){display:none}.visible{visibility:visible}.relative{position:relative}.mb-2{margin-bottom:.5rem}.mb-8{margin-bottom:2rem}.mt-1{margin-top:.25rem}.mt-1\.5{margin-top:.375rem}.flex{display:flex}.h-5{height:1.25rem}.min-h-screen{min-height:100vh}.w-5{width:1.25rem}.w-full{width:100%}.max-w-md{max-width:28rem}.flex-grow{flex-grow:1}.cursor-default{cursor:default}.cursor-pointer{cursor:pointer}.select-none{-webkit-user-select:none;-moz-user-select:none;user-select:none}.flex-col{flex-direction:column}.flex-wrap{flex-wrap:wrap}.items-start{align-items:flex-start}.items-center{align-items:center}.justify-center{justify-content:center}.justify-between{justify-content:space-between}.gap-2{gap:.5rem}.gap-3{gap:.75rem}.gap-x-4{-moz-column-gap:1rem;column-gap:1rem}.space-y-1>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(.25rem*(1 - var(--tw-space-y-reverse)));margin-bottom:calc(.25rem*var(--tw-space-y-reverse))}.space-y-6>:not([hidden])~:not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1.5rem*(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1.5rem*var(--tw-space-y-reverse))}.overflow-hidden{overflow:hidden}.rounded{border-radius:.25rem}.rounded-2xl{border-radius:1rem}.rounded-lg{border-radius:.5rem}.rounded-xl{border-radius:.75rem}.border{border-width:1px}.border-transparent{border-color:transparent}.bg-gray-100{--tw-bg-opacity:1;background-color:rgb(243 244 246/var(--tw-bg-opacity,1))}.bg-indigo-500{--tw-bg-opacity:1;background-color:rgb(99 102 241/var(--tw-bg-opacity,1))}.bg-indigo-600{--tw-bg-opacity:1;background-color:rgb(79 70 229/var(--tw-bg-opacity,1))}.bg-red-500{--tw-bg-opacity:1;background-color:rgb(239 68 68/var(--tw-bg-opacity,1))}.bg-white{--tw-bg-opacity:1;background-color:rgb(255 255 255/var(--tw-bg-opacity,1))}.p-2{padding:.5rem}.p-4{padding:1rem}.p-6{padding:1.5rem}.px-2{padding-left:.5rem;padding-right:.5rem}.px-3{padding-left:.75rem;padding-right:.75rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.py-0\.5{padding-top:.125rem;padding-bottom:.125rem}.py-3{padding-top:.75rem;padding-bottom:.75rem}.text-2xl{font-size:1.5rem;line-height:2rem}.text-\[10px\]{font-size:10px}.text-lg{font-size:1.125rem;line-height:1.75rem}.text-sm{font-size:.875rem;line-height:1.25rem}.text-xs{font-size:.75rem;line-height:1rem}.font-bold{font-weight:700}.font-semibold{font-weight:600}.uppercase{text-transform:uppercase}.tracking-wider{letter-spacing:.05em}.text-gray-400{--tw-text-opacity:1;color:rgb(156 163 175/var(--tw-text-opacity,1))}.text-gray-500{--tw-text-opacity:1;color:rgb(107 114 128/var(--tw-text-opacity,1))}.text-gray-700{--tw-text-opacity:1;color:rgb(55 65 81/var(--tw-text-opacity,1))}.text-indigo-200{--tw-text-opacity:1;color:rgb(199 210 254/var(--tw-text-opacity,1))}.text-indigo-600{--tw-text-opacity:1;color:rgb(79 70 229/var(--tw-text-opacity,1))}.text-white{--tw-text-opacity:1;color:rgb(255 255 255/var(--tw-text-opacity,1))}.underline{text-decoration-line:underline}.decoration-dotted{text-decoration-style:dotted}.shadow-md{--tw-shadow:0 4px 6px -1px rgba(0,0,0,.1),0 2px 4px -2px rgba(0,0,0,.1);--tw-shadow-colored:0 4px 6px -1px var(--tw-shadow-color),0 2px 4px -2px var(--tw-shadow-color)}.shadow-md,.shadow-xl{box-shadow:var(--tw-ring-offset-shadow,0 0 #0000),var(--tw-ring-shadow,0 0 #0000),var(--tw-shadow)}.shadow-xl{--tw-shadow:0 20px 25px -5px rgba(0,0,0,.1),0 8px 10px -6px rgba(0,0,0,.1);--tw-shadow-colored:0 20px 25px -5px var(--tw-shadow-color),0 8px 10px -6px var(--tw-shadow-color)}.filter{filter:var(--tw-blur) var(--tw-brightness) var(--tw-contrast) var(--tw-grayscale) var(--tw-hue-rotate) var(--tw-invert) var(--tw-saturate) var(--tw-sepia) var(--tw-drop-shadow)}.transition{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,-webkit-backdrop-filter;transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter;transition-property:color,background-color,border-color,text-decoration-color,fill,stroke,opacity,box-shadow,transform,filter,backdrop-filter,-webkit-backdrop-filter;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s}.transition-all{transition-property:all;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s}.transition-colors{transition-property:color,background-color,border-color,text-decoration-color,fill,stroke;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:.15s}.hover\:border-gray-200:hover{--tw-border-opacity:1;border-color:rgb(229 231 235/var(--tw-border-opacity,1))}.hover\:bg-gray-50:hover{--tw-bg-opacity:1;background-color:rgb(249 250 251/var(--tw-bg-opacity,1))}.hover\:bg-indigo-700:hover{--tw-bg-opacity:1;background-color:rgb(67 56 202/var(--tw-bg-opacity,1))}.focus\:ring-indigo-500:focus{--tw-ring-opacity:1;--tw-ring-color:rgb(99 102 241/var(--tw-ring-opacity,1))}.active\:scale-\[0\.98\]:active{--tw-scale-x:0.98;--tw-scale-y:0.98;transform:translate(var(--tw-translate-x),var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y))}.group:hover .group-hover\:text-indigo-800{--tw-text-opacity:1;color:rgb(55 48 163/var(--tw-text-opacity,1))}</style>
    <style>
        .task-checkbox:checked + .task-text,
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
                <p class="text-indigo-200 text-xs">Серверное хранение</p>
                <span id="sync-status" class="text-white text-[10px] bg-indigo-500 px-2 py-0.5 rounded">Сохранено</span>
            </div>
        </div>

<!-- Список задач -->
        <div class="p-6">
            <div id="todo-container" class="space-y-6 mb-8">
                
                <!-- Группа 1: Утром -->
                <section>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-3">Утром:</h2>
                    <ul class="space-y-1">
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-1" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Тиньков кешбек (отец)</span>
                        </li>
							<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-2" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
							<div class="task-content flex flex-wrap items-center gap-x-4 flex-grow">
                            <a href="https://www.avito.ru/moskva_i_mo/hobbi_i_otdyh?cd=1&q=wegym+%D0%BA%D1%83%D1%82%D1%83%D0%B7%D0%BE%D0%B2%D1%81%D0%BA%D0%B8%D0%B9" target="_blank" class="task-link group">
                                <span class="task-text text-indigo-600 group-hover:text-indigo-800 text-lg select-none cursor-pointer underline decoration-dotted">Wegym</span>
                            </a>
                            <a href="https://www.avito.ru/moskva_i_mo/hobbi_i_otdyh?cd=1&context=H4sIAAAAAAAA_wEmANn_YToxOntzOjE6InkiO3M6MTY6ImNyUXlteW1LeXdyTGxhWjUiO30T1CZYJgAAAA&localPriority=0&q=world+class+%D0%B0%D0%BC%D0%B8%D0%BD%D1%8C%D0%B5%D0%B2%D1%81%D0%BA%D0%B8%D0%B9" target="_blank" class="task-link group">
                                <span class="task-text text-indigo-600 group-hover:text-indigo-800 text-lg select-none cursor-pointer underline decoration-dotted">World class</span>
                            </a>
                            </div>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-3" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <div class="task-content flex-grow">
                                <a href="https://pepper.ru/new" target="_blank" class="task-link group">
                                    <span class="task-text text-indigo-600 group-hover:text-indigo-800 text-lg select-none cursor-pointer underline decoration-dotted">Pepper</span>
                                </a>
                            </div>
                        </li>

                        <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-4" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Тиньков кешбек (мой)</span>
                        </li>

						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-5" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Тиньков кешбек (мамин)</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-6" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Тиньков кешбек (сашкин)</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-7" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Помыть рожу и намазать кремом</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-8" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Миноксидил</span>
                        </li>
						 <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-9" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Протеин</span>
                        </li>
						
                    </ul>
                </section>

                <!-- Группа 2: Вечером -->
                <section>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2 px-3">Вечером:</h2>
                    <ul class="space-y-1">
                        <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-10" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Финастерид</span>
                        </li>
                        <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-11" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Протеин</span>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-12" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Миноксидил</span>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-13" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Протеин</span>
                        </li>
						<li class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-14" class="task-checkbox mt-1.5 w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
                            <div class="task-content flex flex-col flex-grow">
                               <span class="task-text text-gray-700 text-lg select-none cursor-pointer">Помыть и намазать рожу:</span>
                                <!-- Описание мелким шрифтом -->
                                <p class="task-description text-sm text-gray-500 select-none cursor-default">
								<b>Понедельник</b> - BHA<br>
								<b>Вторник</b> - Mixit<br>
								<b>Среда</b> - Ретиноид<br>
								<b>Четверг</b> - Mixit<br>
								<b>Пятница</b> - BHA<br>
								<b>Суббота</b> - Глина<br>
								<b>Воскресенье</b> - Ретиноид и дермапен (без миноксидила)</p>
                            </div>
                        </li>
						<li class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200">
                            <input type="checkbox" data-id="task-15" class="task-checkbox w-5 h-5 text-indigo-600 rounded focus:ring-indigo-500 cursor-pointer">
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

        // Состояние, прочитанное функцией из Object Storage
        const initialState = <?php echo json_encode((object)$initialState, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT); ?>;
        const storageError = <?php echo $storageError ? 'true' : 'false'; ?>;

        // Тот же адрес страницы + ?api=state (JSON-эндпоинт функции)
        const apiUrl = (() => {
            const u = new URL(window.location.href);
            u.search = '';
            u.hash = '';
            u.searchParams.set('api', 'state');
            return u.toString();
        })();

        let badgeTimer = null;
        const showBadge = (text, isError = false) => {
            syncLabel.textContent = text;
            syncLabel.classList.toggle('bg-red-500', isError);
            syncLabel.classList.toggle('bg-indigo-500', !isError);
            syncLabel.classList.add('show');
            clearTimeout(badgeTimer);
            badgeTimer = setTimeout(() => syncLabel.classList.remove('show'), isError ? 4000 : 2000);
        };

        const updateButtonUI = () => {
            const checkboxes = document.querySelectorAll('.task-checkbox');
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            const allChecked = checkedCount === checkboxes.length && checkboxes.length > 0;
            document.getElementById('btn-text').textContent = allChecked ? 'Снять все' : 'Отметить все как выполненные';
        };

        const applyState = (state) => {
            document.querySelectorAll('.task-checkbox').forEach(cb => {
                cb.checked = !!state[cb.dataset.id];
            });
            updateButtonUI();
        };

        // Отправляем на сервер только изменённые чекбоксы; сервер сливает их
        // с состоянием в бакете. Запросы идут строго по очереди.
        let saveQueue = Promise.resolve();
        let pendingSaves = 0;

        const saveChanges = (changes) => {
            pendingSaves++;
            saveQueue = saveQueue.then(async () => {
                try {
                    const res = await fetch(apiUrl, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(changes)
                    });
                    if (!res.ok) throw new Error('HTTP ' + res.status);
                    showBadge('Сохранено');
                } catch (e) {
                    console.error('Ошибка сохранения:', e);
                    showBadge('Ошибка сохранения', true);
                } finally {
                    pendingSaves--;
                }
            });
        };

        // Подтягиваем актуальное состояние (например, отметки с другого устройства)
        const refreshFromServer = async () => {
            if (pendingSaves > 0) return;
            try {
                const res = await fetch(apiUrl, { cache: 'no-store' });
                if (!res.ok) return;
                const state = await res.json();
                if (pendingSaves === 0) applyState(state);
            } catch (e) {
                console.error('Ошибка обновления:', e);
            }
        };

        toggleBtn.addEventListener('click', () => {
            const checkboxes = document.querySelectorAll('.task-checkbox');
            const newState = !Array.from(checkboxes).every(cb => cb.checked);
            const changes = {};
            checkboxes.forEach(cb => {
                cb.checked = newState;
                changes[cb.dataset.id] = newState;
            });
            updateButtonUI();
            saveChanges(changes);
        });

        // Клик по тексту задачи (кроме ссылок) переключает чекбокс
        document.addEventListener('click', (e) => {
            if (e.target.closest('.task-link')) return;
            const text = e.target.closest('.task-text');
            if (!text) return;
            const cb = text.closest('li').querySelector('.task-checkbox');
            cb.checked = !cb.checked;
            updateButtonUI();
            saveChanges({ [cb.dataset.id]: cb.checked });
        });

        // Клик по самому чекбоксу
        document.addEventListener('change', (e) => {
            if (!e.target.classList.contains('task-checkbox')) return;
            updateButtonUI();
            saveChanges({ [e.target.dataset.id]: e.target.checked });
        });

        // Обновляем состояние, когда пользователь возвращается на вкладку
        document.addEventListener('visibilitychange', () => {
            if (document.visibilityState === 'visible') refreshFromServer();
        });

        // Загрузка данных при старте
        window.onload = () => {
            applyState(initialState);
            if (storageError) showBadge('Хранилище недоступно', true);
        };
    </script>
</body>
</html>