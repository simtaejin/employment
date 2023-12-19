<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use \App\Utils\View;

class Guin extends Page {

    public static function getGuin() {

        $content = View::render('pages/guin',[]);

        return parent::getPanel('', $content, 'guin');
    }

}