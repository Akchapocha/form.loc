<?php
/**
 * Модель для работы с index.php
 * Created by PhpStorm.
 * Date: 20.04.2017
 * Time: 15:16
 */

/**
 * Подключаем файл соединения с базой данных
 */
require_once '/config/db.php';

/**
 * Получаем массив всех данных из базы отсортированый по дате в обратном порядке при помощи RedBeanPHP
 * |**LIMIT 3*| - если раскомментировать, то будет отображаться только три последних добавленных комментария на странице
 * @return array
 */
function getTable()
{
    $sql = 'SELECT *
            FROM `comments`
            ORDER BY `date` DESC
            /**LIMIT 3*/';
    return R::getAll($sql);
}

/**
 * Отправляем в базу данных новую строку при помощи RedBeanPHP
 * @param string $username имя пользователя
 * @param string $date дата и время добавления
 * @param string $comment текст комментария
 */
function addToTable($username, $date, $comment)
{
    $comments = R::dispense('comments');
    $comments->username = $username;
    $comments->date = $date;
    $comments->comment = $comment;
    R::store($comments);
}