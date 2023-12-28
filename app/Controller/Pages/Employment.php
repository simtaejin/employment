<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use App\Model\Entity\Guin as EntityGuin;
use App\Model\Entity\Gujig as EntityGujig;
use App\Model\Entity\Employment as EntityEmployment;
use \App\Utils\Common;
use \App\Utils\View;

class Employment extends Page
{

    public static function getEmploymentCreate()
    {

        $content = View::render('pages/employment_Create', []);

        return parent::getPanel('', $content, 'employment');
    }

    public static function getEmploymentStore($request)
    {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $obj = new EntityEmployment();
        $obj->memberIdx = $obMember['idx'];
        $obj->guinIdx = $postVars['guin_idx'];
        $obj->gujigIdx = $postVars['gujig_idx'];
        $obj->applicationDate = $postVars['applicationDate'];
        $obj->applicationTime = $postVars['applicationTime'];

        $_idx = $obj->created();
        Common::error_loc_msg('/page/employment', '저장 되었습니다.');
    }

    public static function getGuinAutocomplete($request)
    {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $results = EntityGuin::getGuinSearch($obMember['idx'], $postVars['value']);

        $arr = array();
        $i = 0;
        while ($obj = $results->fetchObject(EntityGuin::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['guinName'] = $obj->guinName;
            $i++;
        }

        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }

    public static function getGujigAutocomplete($request)
    {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $results = EntityGujig::getGujigSearch($obMember['idx'], $postVars['value']);

        $arr = array();
        $i = 0;
        while ($obj = $results->fetchObject(EntityGujig::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['gujigName'] = $obj->gujigName;
            $i++;
        }

        return json_encode($arr, JSON_UNESCAPED_UNICODE);
    }
}