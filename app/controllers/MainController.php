<?php

namespace app\controllers;

class MainController extends AppController
{
    public string $layout = 'main';

    public function indexAction()
    {
        $this->layout = 'default';
//        $this->view   = 'test';
        $name   = 'Pavel';
        $hi     = 'hello';
        $colors = [
            'white' => 'Белый',
            'black' => 'Черный',
        ];
        $title = 'PAGE TITLE';
        $this->set(compact('name', 'hi', 'colors', 'title'));
    }
}