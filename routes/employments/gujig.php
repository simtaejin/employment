<?php

use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/page/gujig',[
    function() {
        return new Response(200, Pages\Gujig::getGujig());
    }
]);
