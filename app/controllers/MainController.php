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
        $posts = App::$app->cache->get('posts');

        if (!$posts) {
            $posts = \R::findAll('posts');
            APP::$app->cache->set('posts', $posts, 3600*24);
        }

        $post  = \R::findOne('posts', 'id=2');
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