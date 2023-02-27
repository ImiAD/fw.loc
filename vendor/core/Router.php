<?php


class Router
{
    /**
     * @var array содержит текущий маршрут
     */
    protected static array $route  = [];
    /**
     * @var array содержит все маршруты, таблица маршрутов
     */
    protected static array $routes = [];

    public function __construct()
    {

    }

    /**
     * добавляет маршрут в таблицу маршрутов
     * @param string $regexp регулярное выражение, url, который прописывает пользователь
     * @param array $route маршрут ([controller, action, params])
     */
    public static function add(string $regexp, array $route = []): void
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

    /**
     * Можно сделать protected или private
     * Проверяет регулярное выражение и записывает ассоциативный массив с контроллером и экшином
     * @param string $url
     * @return bool
     */
    public static function matchRoute( string $url): bool
    {

        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#$pattern#i", $url, $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (!isset($route['action'])) {
                    $route['action'] = 'index';
                }
                self::$route = $route;
                return true;
            }
        }

        return false;
    }

    /**
     * Перенаправляет url по корректному маршруту
     * @param $url string
     */
    public static function dispatch(string $url): void
    {
        if (self::matchRoute($url)) {
            $controller = self::upperCamelCase(self::$route['controller']);
            if (class_exists($controller)) {
                $cObj = new $controller;
                $action = self::lowerCamelCase(self::$route['action'].'Action');
                if (method_exists($cObj, $action)) {
                    $cObj->$action();
                } else {
                    echo "Метод <b>$controller::$action</b> не найден.";
                }
            } else {
                echo "Контроллер <b>$controller</b> не найден.";
            }
        } else {
            http_response_code(404);
            require_once '404.html';
        }
    }

    /**
     * Из post-new делаем PostNew, для запуска метода
     * @param $string
     * @return string
     */
    protected static function upperCamelCase($string): string
    {
        return str_replace(' ','', ucwords(str_replace('-',' ', $string)));
    }

    /**
     * Из test-page делаем testPage, для запуска метода
     * @param $string
     * @return string
     */
    protected static function lowerCamelCase($string): string
    {
        return lcfirst(self::upperCamelCase($string));
    }
}