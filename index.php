<?php
# session
session_start();

# Отключение вывода ошибок
error_reporting(0);

# Основной файл системы
require 'system/Entrance.php';

# Подключение к БД
require 'app/config/db_config.php';

# Конфигурация маршрутизатора
require 'app/config/router_config.php';

# Примеры структуры ROC, динамический вызов
$app = ROC::app();

# Распределение маршрутизатора (правила регистрации)
foreach ($router_config as $path => $rule)
{
    $app->route($path, $rule);
}

# Согласованные правила
$isExistRule = true;

# Распределение маршрутизатора (экземпляр класса)
foreach ($router_config as $path => $rule)
{
    $nowRoute = $app->getNowRoute();

    if (is_array($nowRoute) && $rule == $nowRoute)
    {
        # Очистить ранее зарегистрированный
        $app->clearRoutes();

        # Конкретизация Class
        $class = '\app\controller\\'.$rule[0];

        $rule[0] = new $class($app, $db_config);

        # Только зарегистрированный URL, соответствующий текущему маршрутизатору
        $app->route($path, $rule);

        $isExistRule = true;

        break;
    }

    $isExistRule = false;
}

if (!$isExistRule)
{
    $app->clearRoutes();
}

# Старт
$app->start();
?>
