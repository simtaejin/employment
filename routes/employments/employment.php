<?php

use \App\Http\Response;
use \App\Controller\Pages;


$obRouter->get('/page/employment',[
    'middlewares' => [
        'required-admin-login'
    ],
    function() {
        return new Response(200, Pages\Employment::getEmploymentCreate());
    }
]);
