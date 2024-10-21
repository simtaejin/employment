<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use \App\Utils\Common;
use \App\Utils\View;
use \App\Model\Entity\Guin as EntityGuin;
use \App\Model\Entity\Gujig as EntityGujig;
use \App\Model\Entity\Employment as EntityEmployment;

class Guin extends Page
{

    public static function getGuin()
    {

        $content = View::render('pages/guin', [
            'idx' => '',
            'registerNumber' => '',
            'guinName' => '',
            'postcode' => '',
            'roadAddress' => '',
            'jibunAddress' => '',
            'detailAddress' => '',
            'extraAddress' => '',
            'phoneNumber_1' => '',
            'phoneNumber_2' => '',
            'joinItemsOptions' => self::getJoinItemsOptions(),
            'joinDate' => '',
            'duesDate' => '',
            'duesPrice' => '',
            'joinStatusOptions' => self::getJoinStatusOptions(),
            'bigo' => '',
            'guinLists' => self::guinLists(),
            'gujinLists' =>''
        ]);

        return parent::getPanel('', $content, 'guin');
    }

    public static function getJoinItemsOptions($value = 0) {
        $array = ['0'=>'가사일','1'=>'식당일', '2'=>'건설인력'];

        $rows = "";
        foreach ($array as $k => $v) {
            $rows .= View::render('pages/joinItemsOptions', [
               'value' => $k,
               'text' => $v,
               'selected' => ($k == $value) ? 'selected' : '',
            ]);
        }

        return $rows;
    }



    public static function getJoinStatusOptions($value = 0)
    {
        $array = ['0'=>'중지','1'=>'가입중'];

        $rows = "";
        foreach ($array as $k => $v) {
            $rows .= View::render('pages/joinStatusOptions', [
               'value' => $k,
               'text' => $v,
               'selected' => ($k == $value) ? 'selected' : '',
            ]);
        }

        return $rows;
    }

    public static function postGuin($request)
    {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $obj = new EntityGuin();
        $obj->idx = isset($postVars['idx']) ? $postVars['idx'] : '';
        $obj->memberIdx = $obMember['idx'];
        $obj->registerNumber = $postVars['registerNumber'];
        $obj->guinName = $postVars['guinName'];
        $obj->postcode = $postVars['postcode'];
        $obj->roadAddress = $postVars['roadAddress'];
        $obj->jibunAddress = $postVars['jibunAddress'];
        $obj->detailAddress = $postVars['detailAddress'];
        $obj->extraAddress = $postVars['extraAddress'];
        $obj->phoneNumber_1 = $postVars['phoneNumber_1'];
        $obj->phoneNumber_2 = $postVars['phoneNumber_2'];
        $obj->items = $postVars['items'];
        $obj->joinDate = $postVars['joinDate'];
        $obj->duesDate = $postVars['duesDate'];
        $obj->duesPrice = $postVars['duesPrice'];
        $obj->joinStatus = $postVars['joinStatus'];
        $obj->bigo = $postVars['bigo'];

        if (!empty($postVars['idx'])) {
            $_idx = $obj->updated();
            Common::error_loc_msg('/page/guin/'.$postVars['idx'], '수정 되었습니다.');
        } else {
            $_idx = $obj->created();
            Common::error_loc_msg('/page/guin', '저장 되었습니다.');
        }

    }

    public static function getViewGuin($idx) {
        $obj = EntityGuin::getGuin('idx='.$idx,'','')->fetchObject(EntityGuin::class);

        $content = View::render('pages/guin', [
            'idx' => $obj->idx,
            'registerNumber' => $obj->registerNumber,
            'guinName' => $obj->guinName,
            'postcode' => $obj->postcode,
            'roadAddress' => $obj->roadAddress,
            'jibunAddress' => $obj->jibunAddress,
            'detailAddress' => $obj->detailAddress,
            'extraAddress' => $obj->extraAddress,
            'phoneNumber_1' => $obj->phoneNumber_1,
            'phoneNumber_2' => $obj->phoneNumber_2,
            'joinItemsOptions' => self::getJoinItemsOptions($obj->items),
            'joinDate' => substr($obj->joinDate, 0, 10),
            'duesDate' => substr($obj->duesDate, 0, 10),
            'duesPrice' => $obj->duesPrice,
            'joinStatusOptions' => self::getJoinStatusOptions($obj->joinStatus),
            'bigo' => strip_tags($obj->bigo),
            'guinLists' => self::guinLists(),
            'gujinLists' => self::gujinLists($idx),
        ]);

        return parent::getPanel('', $content, 'guin');
    }

    public static function guinLists()
    {
        $guin_obj = EntityGuin::getGuin('','','');

        $array = array();
        $i = 0;

        while ($emp = $guin_obj->fetchObject(EntityGuin::class)) {
            if ($emp) {
                $array[$i]['idx'] = $emp->idx;
                $array[$i]['registerNumber'] = $emp->registerNumber;
                $array[$i]['guinName'] = $emp->guinName;

                $i++;
            }

        }

        $rows = "";
        foreach ($array as $k => $v) {
            $rows .= View::render('pages/saramListOptions', [
                'idx' => $v['idx'],
                'text' => $v['registerNumber']." | ".$v['guinName'],
            ]);
        }

        return $rows;
    }
    public static function gujinLists($idx)
    {
        if (!empty($idx)) {
            $emp_obj = EntityEmployment::getGujigsByGuinIdx($idx);

            $array = array();
            $i = 0;
            while ($emp = $emp_obj->fetchObject(EntityEmployment::class)) {
                $gujig_info = EntityGujig::getGujig("idx=".$emp->idx,"","","*")->fetchObject(EntityGujig::class);

                $array[$i]['registerNumber'] = $gujig_info->registerNumber;
                $array[$i]['gujigName'] = $gujig_info->gujigName;
                $array[$i]['jumin'] = $gujig_info->jumin;
                $array[$i]['jumin'] = $gujig_info->jumin;
                $array[$i]['phoneNumber_1'] = $gujig_info->phoneNumber_1;
                $array[$i]['phoneNumber_2'] = $gujig_info->phoneNumber_2;
                $array[$i]['applicationTime'] = $emp->applicationTime;
                $array[$i]['applicationDate'] = $emp->applicationDate;

                $i++;
            }

            $rows = "";
            foreach ($array as $k => $v) {
                $rows .= View::render('pages/gujigList', [
                    'idx' => $k+1,
                    'registerNumber' => $v['registerNumber'],
                    'gujigName' => $v['gujigName'],
                    'phone'=>$v['phoneNumber_1']." / ".$v['phoneNumber_2'],
                    'applicationDate' => $v['applicationDate'],
                    'applicationTime' => $v['applicationTime'],
                ]);
            }

        }

        return $rows;
    }

    public static function getGuinSearch($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $results = EntityGuin::getGuinSearch($obMember['idx'], $postVars['search_name']);

        $arr = array();
        $i = 0;
        while ($obj = $results->fetchObject(EntityGuin::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['guinName'] = $obj->guinName;
            $i++;
        }

        return [
            'success' => true,
            'data' => $arr,
        ];

    }
}