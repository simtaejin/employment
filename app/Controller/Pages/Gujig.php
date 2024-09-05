<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use \App\Utils\Common;
use \App\Utils\View;
use \App\Model\Entity\Guin as EntityGuin;
use \App\Model\Entity\Gujig as EntityGujig;
use App\Model\Entity\Employment as EntityEmployment;

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
            'guinLists' => '',
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

        if (!empty($postVars['idx'])) {
            $_idx = $obj->updated();
            Common::error_loc_msg('/page/gujig/'.$postVars['idx'], '수정 되었습니다.');
        } else {
            $_idx = $obj->created();
            Common::error_loc_msg('/page/gujig', '저장 되었습니다.');
        }
    }

    public static function getViewGujig($idx) {
        $obj = EntityGujig::getGujig('idx='.$idx,'','')->fetchObject(EntityGujig::class);

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
            'guinLists' => self::guinLists($idx),
        ]);

        return parent::getPanel('', $content, 'gujig');
    }

    public static function guinLists($idx)
    {
        if (!empty($idx)) {
            $emp_obj = EntityEmployment::getGuinsByGujigIdx($idx);

            $array = array();
            $i = 0;

            while ($emp = $emp_obj->fetchObject(EntityEmployment::class)) {
                $guin_info = EntityGujig::getGujig('idx='.$idx,'','')->fetchObject(EntityGujig::class);

                $array[$i]['registerNumber'] = $guin_info->registerNumber;
                $array[$i]['gujigName'] = $guin_info->gujigName;
                $array[$i]['roadAddress'] = $guin_info->roadAddress;
                $array[$i]['detailAddress'] = $guin_info->detailAddress;
                $array[$i]['phoneNumber_1'] = $guin_info->phoneNumber_1;
                $array[$i]['phoneNumber_2'] = $guin_info->phoneNumber_2;
                $array[$i]['applicationTime'] = $emp->applicationTime;
                $array[$i]['applicationDate'] = $emp->applicationDate;

                $i++;
            }

            $rows = "";
            foreach ($array as $k => $v) {
                $rows .= View::render('pages/guinList', [
                    'idx' => $k+1,
                    'registerNumber' => $v['registerNumber'],
                    'gujigName' => $v['gujigName'],
                    'address' => $v['roadAddress']." ".$v['detailAddress'],
                    'phone'=>$v['phoneNumber_1']." / ".$v['phoneNumber_2'],
                    'applicationDate' => $v['applicationDate'],
                    'applicationTime' => $v['applicationTime'],
                ]);
            }
        }

        return $rows;
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