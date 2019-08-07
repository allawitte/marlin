<?php
require '../vendor/autoload.php';
if( !session_id() ) @session_start();
use League\Plates\Engine;
use app\Db;
use \Delight\Auth\Auth;
use Aura\SqlQuery\QueryFactory;
use app\controllers\Home;
use app\Config;
//use \PDO;


$builder = new DI\ContainerBuilder();
$box = new DI\Container();
$builder->addDefinitions([
    PDO::class => function(){

        $config = Config::get()['database'];
        return new PDO("{$config['connection']};dbname={$config['database']};charset={$config['charset']};", $config['username'], $config['password']);
    },
    QueryFactory::class => function(){
        return new QueryFactory('mysql');
    },
    Engine::class => function(){
    return new Engine('../app/views');
    },
    Auth::class => function($box){
        return new Auth($box->get(PDO));
    },


]);
$container = $builder->build();
$auth = new Auth($container->get(PDO));
require '../app/router.php';
