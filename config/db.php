<?php
/**
 * Файл подключения к базе данных
 * Created by PhpStorm.
 * Date: 20.04.2017
 * Time: 15:13
 */

/**
 * Описываем переменные для подключения к базе данных
 */
$dsn = 'mysql:dbname=form;host=127.0.0.1';
$user = 'root';
$password = '';

/**
 * Подключаем ORM RedBeanPHP
 */
require_once '/libs/redbean/rb.php';

if (!R::testConnection()) {
    R::setup($dsn, $user, $password, true);
}
