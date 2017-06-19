<?php

use CapsuleManager\Wrapper\Manager;
use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;

include '../vendor/autoload.php';
include '../.env.php';
include 'User.php';

$dsn = "mysql:host=" . DBHOST;
$pdo = new \PDO($dsn, DBUSER, DBPASS);

$capsule = new Manager($pdo);

// Set the event dispatcher used by Eloquent models... (optional)
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();


dd(User::all()->last()->login);

