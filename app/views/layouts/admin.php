<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php \fw\core\base\View::getMeta() ?>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet">

    <!--[if lt IE 9]>
    <script src="https://cdn.jsdelivr.net/npm/html5shiv@3.7.3/dist/html5shiv.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/respond.js@1.4.2/dest/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<dvi class="container">
    <ul class="nav nav-pills">
        <li><a href="/">Home</a></li>
        <li><a href="/page/about">About</a></li>
        <li><a href="/admin">Admin</a></li>
    </ul>

    <h1>Админка!</h1>
    <?= $content ?>

    <?php //debug(\vendor\core\Db::$countSql) ?>
    <?php //debug(\vendor\core\Db::$queries) ?>
</dvi>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="/bootstrap/js/bootstrap.min.js"></script>
<?php
foreach ($scripts as $script) {
    echo $script;
}
?>
</body>
</html>