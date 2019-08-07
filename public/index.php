<?php
require '../vendor/autoload.php';
if( !session_id() ) @session_start();
use League\Plates\Engine;
use app\Db;
use \Delight\Auth\Auth;
use app\controllers\Home;
$builder = new DI\ContainerBuilder();
$box = new DI\Container();
$builder->addDefinitions([
    Engine::class => function(){
    return new Engine('../app/views');
    },
    Auth::class => new \Delight\Auth\Auth($box->get('app\Db')->getPdo())
]);
$container = $builder->build();
require '../app/router.php';
