<?php

namespace app\controllers;

use app\models\Main;
use fw\core\base\Controller;

class AppController extends Controller
{
    public array $menu;
    public array $meta = [];

    public function __construct($route)
    {
        parent::__construct($route);
//        if ($this->route['action'] == 'Test') {
//            echo '<h1>TEST</h1>';
//        }
        new Main();
        $this->menu = \R::findAll('category');
    }

    protected function setMeta(string $title = '', string $desc = '', string $keywords = '')
    {
        $this->meta['title']    = $title;
        $this->meta['desc']     = $desc;
        $this->meta['keywords'] = $keywords;
    }
}