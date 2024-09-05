<?php

use App\Http\Response;
use App\Controller\Pages;

$obRouter->get('/login', [
    'middlewares' => [
        'required-logout'
    ],
    function ($request) {
        return new Response(200, Pages\Login::getLogin($request));
    }
]);

$obRouter->post('/login', [
    'middlewares' => [
        'required-logout'
    ],
    function ($request) {
        return new Response(200, Pages\Login::setLogin($request));
    }
]);

$obRouter->get('/logout', [
    'middlewares' => [
        'required-login'
    ],
    function ($request) {
        return new Response(200, Pages\Login::setLogout($request));
    }
]);