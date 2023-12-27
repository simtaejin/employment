<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use \App\Utils\Common;
use \App\Utils\View;
use \App\Model\Entity\Gujig as EntityGujig;

class Gujig extends Page {

    public static function getGujig() {

        $content = View::render('pages/gujig',[
            'idx' => '',
            'registerNumber' => '',
            'gujigName' => '',
            'jumin' => '',
            'postcode' => '',
            'roadAddress' => '',
            'jibunAddress' => '',
            'detailAddress' => '',
            'extraAddress' => '',
            'phoneNumber_1' => '',
            'phoneNumber_2' => '',
        ]);

        return parent::getPanel('', $content, 'gujig');
    }

    public static function postGujig($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();


        $obj = new EntityGujig();
        $obj->idx = isset($postVars['idx']) ? $postVars['idx'] : '';
        $obj->memberIdx = $obMember['idx'];
        $obj->registerNumber = $postVars['registerNumber'];
        $obj->gujigName = $postVars['gujigName'];
        $obj->jumin = $postVars['jumin'];
        $obj->postcode = $postVars['postcode'];
        $obj->roadAddress = $postVars['roadAddress'];
        $obj->jibunAddress = $postVars['jibunAddress'];
        $obj->detailAddress = $postVars['detailAddress'];
        $obj->extraAddress = $postVars['extraAddress'];
        $obj->phoneNumber_1 = $postVars['phoneNumber_1'];
        $obj->phoneNumber_2 = $postVars['phoneNumber_2'];

        if (isset($postVars['idx'])) {
            $_idx = $obj->updated();
            Common::error_loc_msg('/page/gujig/'.$postVars['idx'], '수정 되었습니다.');
        } else {
            $_idx = $obj->created();
            Common::error_loc_msg('/page/gujig', '저장 되었습니다.');
        }
    }

    public static function getViewGujig($idx) {
        $obj = EntityGujig::getGujig('idx='.$idx)->fetchObject(EntityGujig::class);

        $content = View::render('pages/gujig', [
            'idx' => $obj->idx,
            'registerNumber' => $obj->registerNumber,
            'gujigName' => $obj->gujigName,
            'jumin' => $obj->jumin,
            'postcode' => $obj->postcode,
            'roadAddress' => $obj->roadAddress,
            'jibunAddress' => $obj->jibunAddress,
            'detailAddress' => $obj->detailAddress,
            'extraAddress' => $obj->extraAddress,
            'phoneNumber_1' => $obj->phoneNumber_1,
            'phoneNumber_2' => $obj->phoneNumber_2,
        ]);

        return parent::getPanel('', $content, 'guin');
    }

    public static function getGujigSearch($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $results = EntityGujig::getGujigSearch($obMember['idx'], $postVars['search_name']);

        $arr = array();
        $i = 0;
        while ($obj = $results->fetchObject(EntityGujig::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['gujigName'] = $obj->gujigName;
            $i++;
        }

        return [
            'success' => true,
            'data' => $arr,
        ];

    }
}