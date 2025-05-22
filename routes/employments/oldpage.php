<?php

use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/page/oldgujig', [
    'middlewares' => [
        'required-login'
    ],
    function ($request) {
        return new Response(200, Pages\OldPage::getOldGujig($request));
    }
]);

$obRouter->get('/page/oldguin', [
    'middlewares' => [
        'required-login'
    ],
    function ($request) {
        return new Response(200, Pages\OldPage::getOldGuin($request));
    }
]);
