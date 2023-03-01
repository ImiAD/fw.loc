<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{
//    public string $layout = 'main';

    public function indexAction()
    {
        $model = new Main();
        $posts = \R::findAll('posts');
        $post  = \R::findOne('posts', 'id=2');
//        debug($post);
        $menu  = $this->menu;
        $title = 'PAGE TITLE';
//        $this->setMeta('Главная странца', 'Описание страницы', 'Ключевые слова');
        $this->setMeta($post->title, $post->description, $post->keywords);
        $meta = $this->meta;
        $this->set(compact('title', 'posts', 'menu', 'meta'));
    }

    public function testAction()
    {
        $this->layout = 'test';
    }
}