<?php

namespace app\controllers;

use app\models\Main;
use vendor\core\App;
use vendor\core\base\View;

class MainController extends AppController
{
//    public string $layout = 'main';

    public function indexAction()
    {
        $model = new Main();
        $posts = \R::findAll('posts');
        $post  = \R::findOne('posts', 'id=2');
        $menu  = $this->menu;
        $title = 'PAGE TITLE';
        $meta = View::setMeta('Главная странца','Описание страницы','Ключевые слова');
        $this->set(compact('title', 'posts', 'menu', 'meta'));
    }

    public function testAction()
    {
        if ($this->isAjax()) {
            $model = new Main();
            $post  = \R::findOne('posts', "id ={$_POST['id']}");
            $this->loadView('_test', compact('post'));
            die;
        }

        echo 222;
//        $this->layout = 'test';
    }
}