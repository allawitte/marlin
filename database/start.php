<?php
include_once 'Connection.php';
$config = include_once '../config.php';
include_once 'Db.php';

return new Db(
    Connection::make($config['database'])
);
