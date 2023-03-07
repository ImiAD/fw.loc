<?php

namespace fw\core;

class Db
{
    use TSingleton;

    /**
     * переменная для создания объекта класса PDO
     */
    protected $pdo;

    /**
     * кол-во запросов
     */
    public static int $countSql  = 0;

    /**
     * сами запросы
     */
    public static array $queries = [];

    protected function __construct()
    {
        $db = require ROOT . '/config/config_db.php';
        require_once LIBS . '/rb.php';

        /**
         * устанаваливаем соединение с БД
         */
        \R::setup($db['dsn'], $db['user'], $db['pass']);
        \R::freeze(true);
    }

}