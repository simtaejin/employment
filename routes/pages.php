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

//$obRouter->get('/about',[
//    function() {
//        return new Response(200, Pages\About::getAbout());
//    }
//]);
//
//$obRouter->get('/pagina/{idPagina}/{acao}',[
//    function($idPagina,$acao) {
//        return new Response(200, 'pagina '.$idPagina.' - '.$acao);
//    }
//]);
//
//$obRouter->get('/depoimento',[
//    function($request) {
//        return new Response(200, Pages\Testimony::getTestimonies($request));
//    }
//]);
//
//$obRouter->post('/depoimento', [
//    function($request) {
//        return new Response(200, Pages\Testimony::insertTestimony($request));
//    }
//]);
