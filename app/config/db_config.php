<?php

# Конфигурации базы данных
$db_config = array(
    'database_type' => 'mysql',
    # *Необходимый тип соединения по умолчанию: MySQL, MariaDB, MSSQL, Sybase, PostgreSQL, Oracle

    'database_name' => 'rocboss_2_1',
    # *Обязательное, имя базы данных

    'server' => 'localhost',
    # *Обязательное, имя хоста базы данных

    'username' => 'root',
    # *Обязательное, имя пользователя базы данных

    'password' => '123456',
    # *Обязательное, пароль базы данных

    'port' => 3306,
    #  По умолчанию порт базы данных

    'charset' => 'utf8',
    #  По умолчанию кодировка

    'option' => array( PDO::ATTR_CASE => PDO::CASE_NATURAL )
    #  По умолчанию опция pdo: убедитесь, что pdo установлена и включена в php.ini
);

?>
