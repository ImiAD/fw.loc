<?php

namespace app\controllers;

use app\models\Main;
use fw\core\App;
use fw\core\base\View;
use fw\libs\Pagination;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MainController extends AppController
{
//    public string $layout = 'main';

    public function indexAction()
    {
        $model = new Main();

        /**
         * пагинация
         */
        $total      = \R::count('posts');
        $page       = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perpage    = 2;
        $pagination = new Pagination($page, $perpage, $total);
        $start      = $pagination->getStart();

        $posts = \R::findAll('posts', "LIMIT $start, $perpage");
        $menu  = $this->menu;
        $title = 'PAGE TITLE';
        $meta  = View::setMeta('Главная странца','Описание страницы','Ключевые слова');
        $this->set(compact('title', 'posts', 'menu', 'meta', 'pagination', 'total'));
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
    }
}