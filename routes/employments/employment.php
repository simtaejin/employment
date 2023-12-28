<?php

use \App\Http\Response;
use \App\Controller\Pages;


$obRouter->get('/page/employment',[
    'middlewares' => [
        'required-login'
    ],
    function() {
        return new Response(200, Pages\Employment::getEmploymentCreate());
    }
]);

$obRouter->post('/page/employment',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Pages\Employment::getEmploymentStore($request));
    }
]);


$obRouter->post('/page/guin_autocomplete',[
    'middlewares' => [
        'api',
        'required-login'
    ],
    function($request) {
        return new Response(200, Pages\Employment::getGuinAutocomplete($request), 'application/json');
    }
]);

$obRouter->post('/page/gujig_autocomplete',[
    'middlewares' => [
        'api',
        'required-login'
    ],
    function($request) {
        return new Response(200, Pages\Employment::getGujigAutocomplete($request), 'application/json');
    }
]);