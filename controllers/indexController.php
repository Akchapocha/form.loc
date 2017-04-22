<?php
/**
 * Контроллер работы с index.php
 * Created by PhpStorm.
 * Date: 20.04.2017
 * Time: 15:02
 */

/**
 * Подключаем модель
 */
require_once '/models/indexModel.php';

/**
 * Запускаем сессию
 */
session_start();

/**
 * Заполняем соответсвующие поля в отображении комментариев
 */
function getRows()
{
    $table = getTable();
    foreach ($table as $item => $row){
        echo '<div class="comment">
				<div class="comment__header">';
        echo '<h2 class="comment__title">' . $row['username'] . '</h2>';
        echo '<time class="comment__date" datetime="'.obrDate($row['date']).'">' . $row['date'] . '</time>';
        echo '</div>';
        echo '<div class="comment__body">' . $row['comment'] . '</div>';
        echo '</div>';
    }
}

/**
 * Функция изменения формата отображения даты и времени для <time class="comment__date" datetime="
 * @param string $date дата из базы данных
 * @return string дата для вставки в <time class="comment__date" datetime="
 */
function obrDate($date)
{
    $a = preg_replace("/^..\:..\ /", "", $date);
    $y = preg_replace("/^..\...\./", "", $a);                                          /**2014*/
    $b = preg_replace("/^..\./", "", $a);
    $m = preg_replace("/\.....$/", "", $b);                                            /**02*/
    $d = preg_replace("/\...\.....$/", "", $a);                                        /**07*/
    $time = preg_replace("/\ ..\...\.....$/", "", $date);     /**18:05*/
    $datetime = $y.'.'.$m.'.'.$d.'T'.$time;
    return $datetime;
}

/**
 * Функция проверки массива $_POST после рефреша <meta http-equiv="refresh" content="1; URL=http://form.loc">
 * @param array $_SESSION
 * @param array $_POST
 */
function val()
{
    if (($_SESSION['name'] == $_POST['name']) and ($_SESSION['message'] == $_POST['message'])){
        echo '<p style="color: red">Вы уже отправляли такой коментарий';
    } else add();

}

/**
 * Функция проверки и принятия данных из массива $_POST
 * @param array $_POST
 * @param array $err масиив ошибок
 */
function add()
{
    $err =null;
    $err = array();

    /**
     * Проверяем заполнение полей
     */
    if (!empty($_POST)) {
        if (!empty($_POST['name'])) {
            $username = $_POST['name'];
        } else {
            $err[] = '<p style="color: red">Введите Ваше имя';
        }
        $date = date('G:i d.m.Y');
        if (!empty($_POST['message'])) {
            $comment = $_POST['message'];
        } else {
            $err[] = '<p style="color: red">Введите Ваш коментарий';
        }
    } else {
        $err[] = '';
    }

    /**
     * Проверяем повторяющиеся комментарии в базе данных
     */
    foreach (getTable() as $item => $row){
        if ($row['comment'] == $comment){
            $err[] = '<p style="color: red">Такой коментарий уже есть';
        }
    }

    /**
     * Добавляем данные в базу
     * Инициализируем массив $_SESSION для проверки после рефреша <meta http-equiv="refresh" content="1; URL=http://form.loc">
     * Запускаем рефреш страницы
     * @param string $username имя пользователя
     * @param string $date дата и время добавления
     * @param string $comment текст комментария
     */
    if (empty($err)) {
        addToTable($username, $date, $comment);
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['message'] = $_POST['message'];
        echo '<p style="color: green">Коментарий добавлен';
        echo '<meta http-equiv="refresh" content="0; URL=http://form.loc">';
    } else {
        echo $err[0];
    }
}





