<?php
namespace app;
Class Config
{
    public static function get()
    {
        return [
            'database' => [
                'database' => 'marlin',
                'username' => 'root',
                'password' => '',
                'charset' => 'utf8',
                'connection' => 'mysql:host=localhost'
            ],
            'routes' => [
                '/' => 'controllers/index.php',
//        '/about' => 'controllers/about.php',
//        '/create' => 'controllers/create.php',
//        '/store' => 'controllers/store.php',
//        '/update{/id}' => 'controllers/update.php',
//        '/post{/id}' => 'controllers/post.php',
//        '/post/edit{/id}' => 'controllers/edit.php',
//        '/post/delete{/id}' => 'controllers/delete.php',
            ]
        ];
    }
}

