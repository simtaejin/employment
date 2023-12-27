<?php

use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/page/gujig',[
    'middlewares' => [
        'required-login'
    ],
    function() {
        return new Response(200, Pages\Gujig::getGujig());
    }
]);

$obRouter->get('/page/gujig/{idx}', [
    'middlewares' => [
        'required-login'
    ],
    function ($request, $idx) {
        return new Response(200, Pages\Gujig::getViewGujig($idx));
    }
]);

$obRouter->post('/page/gujig', [
    'middlewares' => [
        'required-login'
    ],
    function ($request) {
        return new Response(200, Pages\Gujig::postGujig($request));
    }
]);

$obRouter->post('/page/gujig_search',[
    'middlewares' => [
        'api',
        'required-login'
    ],
    function($request) {
        return new Response(200, Pages\Gujig::getGujigSearch($request), 'application/json');
    }
]);