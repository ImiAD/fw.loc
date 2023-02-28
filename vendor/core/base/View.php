<?php


namespace vendor\core\base;


class View
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
    public string $layout;

    public function __construct(array $route, string $layout = '', string $view = '')
    {
//        var_dump($layout);
//        var_dump($view);
        $this->route = $route;

        if ($layout === false) {
            $this->layout = false;
        } else {
            $this->layout = $layout ?: LAYOUT;
        }

        $this->view = $view;
    }

    /**
     * Принимает 1 параметр - переменную, которую передает пользователь из контроллера в вид, виды и шаблон
     */
    public function render($vars)
    {
        if (is_array($vars)) {
            extract($vars);
        }

        $file_view = APP . "/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();

        if (is_file($file_view)) {
            require_once $file_view;
        } else {
            echo "<p>Не найден вид <b>$file_view</b></p>";
        }

        $content = ob_get_clean();

        if (false !== $this->layout) {
            $file_layout = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($file_layout)) {
                require_once $file_layout;
            } else {
                echo "<p>Не найден шаблон <b>$file_layout</b></p>";
            }
        }
    }
}