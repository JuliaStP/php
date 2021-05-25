<?php
require '../vendor/autoload.php';
require '../base/config.php';

ini_set('display_errors', 'on');
ini_set('error_reporting', E_ALL | E_NOTICE);

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => DB_HOST,
    'database'  => DB_NAME,
    'username'  => DB_USERNAME,
    'password'  => DB_PASSWORD,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();

$capsule->bootEloquent();

$route = new \Base\Route();
$route->add('/', \App\Controller\Signin::class);
$route->add('/admin/users', \App\Controller\Admin\Users::class);
$route->add('/admin/saveUser', \App\Controller\Admin\Users::class, 'saveUser');
$route->add('/admin/deleteUser', \App\Controller\Admin\Users::class, 'deleteUser');
$route->add('/admin/addUser', \App\Controller\Admin\Users::class, 'addUser');

$app = new \Base\Application($route);
$app->run();