<?php

use \App\Http\Response;
use \App\Controller\Pages;


$obRouter->get('/page/agreement',[
    'middlewares' => [
        'required-login'
    ],
    function() {
        return new Response(200, Pages\Agreement::getAgreementList());
    }
]);

$obRouter->get('/page/agreementCreate',[
    'middlewares' => [
        'required-login'
    ],
    function() {
        return new Response(200, Pages\Agreement::getAgreementCreate());
    }
]);

$obRouter->post('/page/agreementSave',[
    'middlewares' => [
        'required-login'
    ],
    function($request) {
        return new Response(200, Pages\Agreement::getAgreementSave($request));
    }
]);

$obRouter->get('/page/agreementView/{idx}',[
    'middlewares' => [
        'required-login'
    ],
    function($request, $idx) {
        return new Response(200, Pages\Agreement::getAgreementView($idx));
    }
]);
