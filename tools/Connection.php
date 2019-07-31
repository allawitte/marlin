<?php

/**
 * Created by PhpStorm.
 * User: HP
 * Date: 7/26/2019
 * Time: 12:44 PM
 */
class Connection
{
    public static function make($config){
        return new PDO("{$config['connection']};dbname={$config['database']};charset={$config['charset']};", $config['username'], $config['password']);
    }

}