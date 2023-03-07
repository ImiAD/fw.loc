<?php

use fw\core\Router;


$query = rtrim($_SERVER['QUERY_STRING'], '/');

define('WWW', __DIR__);
define('CORE', dirname(__DIR__) . '/vendor/fw/core');
define('ROOT', dirname(__DIR__));
define('APP', dirname(__DIR__).'/app');
define('LAYOUT', 'blog');
define('LIBS', dirname(__DIR__) . '/vendor/fw/libs');
define('CACHE', dirname(__DIR__).'/tmp/cache');
define('DEBUG', 1);

require_once '../vendor/fw/libs/functions.php';
//подключение автозагрузчика композера
require_once  __DIR__.'/../vendor/autoload.php';

new \fw\core\App();

// Свое правило, оно должно идти выше дефолтных. Это необходимо, чтобы срабатывало оно, если будет совпадение
Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$', ['controller' => 'Page']);
Router::add('^page/(?P<alias>[a-z-]+)$', ['controller' => 'Page', 'action' => 'view']);

// Ддефолтные правила
Router::add('^admin$', ['controller' => 'User', 'action' => 'index', 'prefix' => 'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$', ['prefix' => 'admin']);

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);

