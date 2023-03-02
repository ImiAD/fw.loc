<?php

namespace vendor\core;

trait TSingleton
{
    /**
     * переменная для созданного объекта класса Db
     */
    protected static $instance;

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}