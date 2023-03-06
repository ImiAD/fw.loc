<?php

namespace vendor\core;

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
     * $regexp регулярное выражение, url, который прописывает пользователь
     * $route маршрут ([controller, action, params])
     */
    public static function add(string $regexp, array $route = []): void
    {
        self::$routes[$regexp] = $route;
    }

    /**
     * возвращает текущий url
     */
    public static function getRoute(): array
    {
        return self::$route;
    }

    /**
     * возвращает все url
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }

    /**
     * Можно сделать protected или private
     * Проверяет регулярное выражение и записывает ассоциативный массив с контроллером и экшином
     */
    public static function matchRoute(string $url): bool
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
                //получаем префикс для админской панели
                if (!isset($route['prefix'])) {
                    $route['prefix'] = '';
                } else {
                    $route['prefix'] .= '\\';
                }
                $route['controller'] = self::upperCamelCase($route['controller']);
                self::$route = $route;

                return true;
            }
        }

        return false;
    }

    /**
     * Перенаправляет url по корректному маршруту
     * @throws \Exception
     */
    public static function dispatch(string $url): void
    {
        $url = self::removeQueryString($url);
        if (self::matchRoute($url)) {
            $controller = 'app\controllers\\'.self::$route['prefix'].self::upperCamelCase(self::$route['controller'].'Controller');
            if (class_exists($controller)) {
                $cObj   = new $controller(self::$route);
                $action = self::lowerCamelCase(self::$route['action'].'Action');
                if (method_exists($cObj, $action)) {
                    $cObj->$action();
                    $cObj->getView();
                } else {
                    throw new \Exception("Метод <b>$controller::$action</b> не найден.", 404);
                }
            } else {
                throw new \Exception("Контроллер <b>$controller</b> не найден.", 404);
            }
        } else {
            throw new \Exception("Страница не найдена.", 404);
        }
    }

    /**
     * Из post-new делаем PostNew, для запуска метода
     */
    protected static function upperCamelCase(string $string): string
    {
        return str_replace(' ','', ucwords(str_replace('-',' ', $string)));
    }

    /**
     * Из Test-page делаем testPage, для запуска метода
     */
    protected static function lowerCamelCase(string $string): string
    {
        return lcfirst(self::upperCamelCase($string));
    }

    /**
     * возвращает строку $url только с неявными GET парамметрами (до ?)
     */
    public static function removeQueryString(string $url): string
    {
        if ($url) {
            $params = explode('&', $url, 2);
                if (false == strpos($params[0], '=')) {
                    return rtrim($params[0], '/');
                } else {
                    return '';
                }
        }

        return $url;
    }
}