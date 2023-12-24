<?php

use \App\Http\Response;
use \App\Controller\Pages;

$obRouter->get('/',[
    function() {
        return new Response(200, Pages\Home::getHome());
    }
]);

include __DIR__ . '/employments.php';