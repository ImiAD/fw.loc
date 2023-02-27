<?php


class Router
{
    /**
     * @route содержит текущий маршрут
     */
    protected static $route  = [];
    /**
     * @routes содержит все маршруты, таблица маршрутов
     */
    protected static $routes = [];

    public function __construct()
    {

    }

    /**
     * @param $regexp string регулярное выражение, url, который прописывает пользователь
     * @param array $route
     */
    public static function add(string $regexp, array $route = []): array
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * @return array возвращает текущий url
     */
    public static function getRoute(): array
    {
        return self::$route;
    }

    /**
     * @return array возвращает все url
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }

    public static function matchRoute( string $url): bool
    {

        foreach (self::$routes as $pattern => $route) {
            if ($url == $pattern) {
                self::$route = $route;
                return true;
            }
        }

        return false;
    }
}