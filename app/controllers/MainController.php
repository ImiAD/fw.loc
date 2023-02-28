<?php

namespace app\controllers;

use app\models\Main;

class MainController extends AppController
{
//    public string $layout = 'main';

    public function indexAction()
    {
        $model  = new Main();
        $posts  = $model->findAll();
//        $posts2 = $model->findOne(1);
//        $data = $model->findBySql("SELECT * FROM {$model->table} WHERE title LIKE ?", ['%вт%']);
        $data = $model->findLike('бе', 'title');
        debug($data);
        $title  = 'PAGE TITLE';
        $this->set(compact('title', 'posts'));
    }
}