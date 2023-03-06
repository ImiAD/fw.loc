<?php

namespace app\controllers;

use app\models\Main;
use fw\core\App;
use fw\core\base\View;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MainController extends AppController
{
//    public string $layout = 'main';

    public function indexAction()
    {

        // create a log channel
        $log = new Logger('name');
        $log->pushHandler(new StreamHandler(ROOT.'/tmp/your.log', Logger::WARNING));

        // add records to the log
        $log->warning('Foo');
        $log->error('Bar');

        $mailer = new \PHPMailer\PHPMailer\PHPMailer();

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
    }
}