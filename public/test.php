<?php
/**
 * подключаем библиотеку
 */
require_once 'rb.php';

/**
 * подключаем файл конфигурации
 */
$db = require_once '../config/config_db.php';

/**
 * устанаваливаем соединение с БД
 */
R::setup($db['dsn'], $db['user'], $db['pass'], $option);

/**
 * проверка соединения с БД, возвращает bool
 */
//var_dump(R::testConnection());

//Create
//$cat = R::dispense('category');
//$cat->title = 'Категория 2';
//var_dump($cat);
//
//$id = R::store($cat);
//var_dump($id);

// Read
//получение данных
//$cat = R::load('category', 2);
//echo $cat->title; echo $cat['title'];

//Update
//$cat = R::load('category', 1);
//echo $cat->title.'<br>';
//$cat->title = 'Категория 3';
//сохранение изменений
//R::store($cat);
//
//$cat        = R::dispense('category');
//$cat->title = 'Категория 4';
//$cat->id    = 2;
//R::store($cat);

//Delete
//$cat = R::load('category', 1);
//R::trash($cat);
//полное удаление таблицы (пересоздание таблицы)
//R::wipe('category');






