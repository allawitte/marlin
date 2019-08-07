<?php
require '../vendor/autoload.php';
use app\controllers\Console;
$console = new Console();
$console->createPosts();