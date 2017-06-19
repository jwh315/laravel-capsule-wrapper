<?php

use CapsuleManager\Wrapper\Manager as Capsule;

include '../vendor/autoload.php';
include '../.env.php';
include 'User.php';

$dsn = "mysql:host=" . DBHOST;
$pdo = new \PDO($dsn, DBUSER, DBPASS);

$capsule = Capsule::init($pdo);

echo \User::all()->last()->login . PHP_EOL;

$user = new User();
$user->login = uniqid('new_user');
$user->save();

echo \User::all()->last()->login . PHP_EOL;

