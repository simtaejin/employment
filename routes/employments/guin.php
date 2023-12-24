<?php

use \App\Http\Response;
use \App\Controller\Pages;


$obRouter->get('/page/guin', [

    function () {
        return new Response(200, Pages\Guin::getGuin());
    }
]);
