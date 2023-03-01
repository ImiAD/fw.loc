<?php

namespace vendor\core;

class Db
{
    /**
     * переменная для создания объекта класса PDO
     */
    protected $pdo;

    /**
     * переменная для созданного объекта класса Db
     */
    protected static $instance;

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
        $db = require ROOT.'/config/config_db.php';
        require_once LIBS.'/rb.php';

        /**
         * устанаваливаем соединение с БД
         */
        \R::setup($db['dsn'], $db['user'], $db['pass']);
        \R::freeze(true);
//        \R::fancyDebug(true);
//        $option = [
//            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
//            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
//        ];
//        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $option);
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

//    /**
//     *  возвращает bool значение (выполнился наш запрос или нет)
//     */
//    public function execute(string $sql, array $params = []): bool
//    {
//        self::$countSql++;
//        self::$queries[] = $sql;
//        $stmt = $this->pdo->prepare($sql);
//
//        return $stmt->execute($params);
//    }
//
//    /**
//     * возвращает данные по запросу $sql
//     */
//    public function query(string $sql, array $params = []): array
//    {
//        self::$countSql++;
//        self::$queries[] = $sql;
//        $stmt = $this->pdo->prepare($sql);
//        $res  = $stmt->execute($params);
//
//        if ($res !== false) {
//            return $stmt->fetchAll();
//        }
//        return [];
//    }
}