<?php

require_once '../vendor/core/Router.php';
require_once '../vendor/libs/functions.php';
//require_once '../app/controllers/Main.php';
//require_once '../app/controllers/Posts.php';
//require_once '../app/controllers/PostsNew.php';

$query = rtrim($_SERVER['QUERY_STRING'], '/');

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__).'/app');

spl_autoload_register(function($class) {
   $file = APP."/controllers/$class.php";

   if (is_file($file)) {
       require_once $file;
   }
});

// Свое правило, оно должно идти выше дефолтных. Это необходимо, чтобы срабатывало оно, если будет совпадение
Router::add('^pages/?(?P<action>[a-z-]+)?$', ['controller' => 'Posts']);

// Ддефолтные правила
Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

debug(Router::getRoutes());

Router::dispatch($query);

