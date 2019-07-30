<?php
include __DIR__ . '/../functions/console.php';
$config =  include __DIR__.'/../config.php';

include_once __DIR__ . '/../database/Db.php';
include_once __DIR__ . '/../database/Connection.php';

include __DIR__.'/../router/router.php';
$db = new Db(
    Connection::make($config['database'])
);
$router = new Router($config['routes']);
//Example of calling router
//
//include __DIR__ . '/../' .$router->getRoute($_SERVER['REQUEST_URI']);
include_once 'footer.php';
?>
