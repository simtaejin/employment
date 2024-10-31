<?php

use \App\Http\Response;
use \App\Controller\Pages;


$obRouter->get('/page/guin', [
    'middlewares' => [
        'required-login'
    ],
    function () {
        return new Response(200, Pages\Guin::getGuin());
    }
]);

$obRouter->get('/page/guin/{idx}', [
    'middlewares' => [
        'required-login'
    ],
    function ($request, $idx) {
        return new Response(200, Pages\Guin::getViewGuin($idx));
    }
]);

$obRouter->post('/page/guin', [
    'middlewares' => [
        'required-login'
    ],
    function ($request) {
        return new Response(200, Pages\Guin::postGuin($request));
    }
]);

$obRouter->post('/page/guin_search',[
    'middlewares' => [
        'api',
        'required-login'
    ],
    function($request) {
        return new Response(200, Pages\Guin::getGuinSearch($request), 'application/json');
    }
]);

$obRouter->get('/page/guin_dues', [
    'middlewares' => [
        'required-login'
    ],
    function ($request) {
        return new Response(200, Pages\Guin::getGuinDues($request));
    }
]);

$obRouter->get('/page/guin_dues/{idx}', [
    'middlewares' => [
        'required-login'
    ],
    function ($request, $idx) {
        return new Response(200, Pages\Guin::getViewGujinDues($idx));
    }
]);

$obRouter->post('/page/guin_dues', [
    'middlewares' => [
        'required-login'
    ],
    function ($request) {
        return new Response(200, Pages\Guin::postGuinDues($request));
    }
]);

$obRouter->post('/page/guin_dues_search',[
    'middlewares' => [
        'api',
        'required-login'
    ],
    function($request) {
        return new Response(200, Pages\Guin::getGuinDuesSearch($request), 'application/json');
    }
]);