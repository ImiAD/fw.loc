<?php

namespace fw\core\base;

abstract class Controller
{
    /**
     * Текущий маршрут и параметы (controller, action, params)
     */
    public array $route = [];

    /**
     *Текущий вид
     */
    public string $view;

    /**
     *Текущий шиблон
     */
    public string $layout = '';

    /**
     *Пользовательские данные
     */
    public array $vars = [];

    public function __construct(array $route)
    {
        $this->route = $route;
        $this->view  = $route['action'];
    }

    public function getView()
    {
        $vObj = new View($this->route, $this->layout, $this->view);
        $vObj->render($this->vars);
    }

    public function set($vars)
    {
        $this->vars = $vars;
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function loadView($view, array $vars = [])
    {
        extract($vars);
        require_once APP."/views/{$this->route['controller']}/{$view}.php";
    }
}