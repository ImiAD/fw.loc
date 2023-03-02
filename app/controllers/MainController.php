<?php

namespace app\controllers;

use app\models\Main;
use vendor\core\App;

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
        $this->setMeta($post->title, $post->description, $post->keywords);
        $meta = $this->meta;
        $this->set(compact('title', 'posts', 'menu', 'meta'));
    }

    public function testAction()
    {
        if ($this->isAjax()) {
            echo 111;
            die;
        }

        echo 222;
//        $this->layout = 'test';
    }
}