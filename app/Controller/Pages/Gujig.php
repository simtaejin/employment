<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use \App\Utils\View;

class Gujig extends Page {

    public static function getGujig() {

        $content = View::render('pages/gujig',[]);

        return parent::getPanel('', $content, 'gujig');
    }
}