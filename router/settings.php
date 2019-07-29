<?php
$config = include __DIR__.'/../config.php';
include'Router.php';
return new Router($config['routes']);