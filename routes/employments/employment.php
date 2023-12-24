<?php

use \App\Http\Response;
use \App\Controller\Pages;


$obRouter->get('/page/employment',[
    function() {
        return new Response(200, Pages\Employment::getEmploymentCreate());
    }
]);
