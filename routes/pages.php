<?php

use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/',[
    function() {
        return new Response(200, Pages\Home::getHome());
    }
]);

$obRouter->get('/page/guin',[
    function() {
        return new Response(200, Pages\Guin::getGuin());
    }
]);

$obRouter->get('/page/gujig',[
    function() {
        return new Response(200, Pages\Gujig::getGujig());
    }
]);

$obRouter->get('/page/employment',[
    function() {
        return new Response(200, Pages\Employment::getEmploymentCreate());
    }
]);
