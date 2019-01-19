<?php die('Access Denied');?>
<section>
    <ol class="bz-breadcrumb">
        <li><a href="{$root}admin">Главная</a></li>
        <li class="bz-active">Информация о системе</li>
    </ol>
    <div class="bz-panel bz-panel-default">
        <div class="bz-panel-hd">
            <h3 class="bz-panel-title">Добро пожаловать в панель управления системой</h3>
        </div>
        <div class="bz-panel-bd">
            Привет, <code>{$loginInfo.username} ({$loginInfo.groupname})</code>!
            <a href="{$root}">На сайт</a> | <a href="{$root}logout">Выход</a>
        </div>
    </div>

    <div class="bz-panel bz-panel-default">
        <div class="bz-panel-hd">
            <h3 class="bz-panel-title">Информация о системе</h3>
        </div>
        <ul class="bz-listUI">
            <li style="border-top:none">Время сервера: {$server.time}</li>
            <li>Порт сервера: {$server.port}</li>
            <li>Домен: {$server.name}</li>
            <li>ОС сервера: {$server.os}</li>
            <li>ПО сервера: {$server.software}/PHP {$server.version}</li>
            <li>База данных: MYSQL {:@mysql_get_server_info()}</li>
            <li>Корневой каталог: {$server.root}</li>
            <li>Макс.загрузка: {$server.upload}</li>
            <li>Размер памяти: {$server.memory_usage}</li>
            <li><h3 class="bz-panel-title">Общая статистика</h3></li>
            <li>Всего пользователей: {$server.user_count}</li>
            <li>Пользователей сегодня: {$server.sign_count}</li>
            <li>Зарегистрированно: {loop $signList $s}@{$s.username} {/loop}</li>
        </ul>
    </div>
</section>
