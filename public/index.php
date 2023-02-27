<?php

require_once '../vendor/core/Router.php';
require_once '../vendor/libs/functions.php';

$query = rtrim($_SERVER['QUERY_STRING'], '/');

//Router::add('posts/add',['controller' => 'Posts', 'action' => 'add']);
//Router::add('posts',['controller' => 'Posts', 'action' => 'index']);
//Router::add('',['controller' => 'Main', 'action' => 'index']);

Router::add('^$');

debug(Router::getRoutes());

if (Router::matchRoute($query)) {
    debug(Router::getRoute());
} else {
    echo '404';
}