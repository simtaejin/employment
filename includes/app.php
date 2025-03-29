<?php
date_default_timezone_set('Asia/Seoul');

require __DIR__.'/../vendor/autoload.php';

use \App\Utils\View;
use \WilliamCosta\DotEnv\Environment;
use \WilliamCosta\DatabaseManager\Database;
use \App\Http\Middleware\Queue as MiddlewareQueue;

Environment::load(__DIR__.'/../');

Database::config(
    getenv('DB_HOST'),
    getenv('DB_NAME'),
    getenv('DB_USER'),
    getenv('DB_PASS'),
    getenv('DB_PORT')
);

define('URL', getenv('URL'));

View::init([
    'URL' => URL,
    'REQUEST_URI' => $_SERVER['REQUEST_URI'],
]);

MiddlewareQueue::setMap([
    'maintenance' => \App\Http\Middleware\maintenance::class,
    'required-logout' => \App\Http\Middleware\RequireLogout::class,
    'required-login' => \App\Http\Middleware\RequireLogin::class,
    'api' => \App\Http\Middleware\Api::class,
]);

MiddlewareQueue::setDefault([
    'maintenance'
]);
