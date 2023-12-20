<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use \App\Utils\View;

class Employment extends Page {

    public static function getEmploymentCreate() {

        $content = View::render('pages/employment_Create',[]);

        return parent::getPanel('', $content, 'employment');
    }
}