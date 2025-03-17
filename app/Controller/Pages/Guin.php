<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use \App\Utils\Common;
use \App\Utils\View;
use \App\Model\Entity\Guin as EntityGuin;
use \App\Model\Entity\Gujig as EntityGujig;
use \App\Model\Entity\Employment as EntityEmployment;
use \App\Model\Entity\Guindues as EntityGuindues;
use WilliamCosta\DatabaseManager\Database;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Guin extends Page
{

    public static function getGuin()
    {

        $content = View::render('pages/guin', [
            'idx' => '',
            'registerNumber' => '',
            'guinName' => '',
            'business' => '',
            'industry' => '',
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
        $obj->business = $postVars['business'];
        $obj->industry = $postVars['industry'];
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
            $obj->updated();
            $_idx = $postVars['idx'];

            $dues_obj = Common::getGuinDues($_idx);
            if (empty($dues_obj)) {
                if ($postVars['duesDate'] && $postVars['duesPrice']) {
                    $deus = new EntityGuindues();
                    $deus->memberIdx = $obMember['idx'];
                    $deus->guinIdx = $_idx;
                    $deus->duesDate = $postVars['duesDate'];
                    $deus->duesPrice = $postVars['duesPrice'];
                    $deus->created();
                }
            } else {
                if ($postVars['duesDate'] && $postVars['duesPrice']) {
                    $dues = new EntityGuindues();
                    $dues->idx = $dues_obj->idx;
                    $dues->memberIdx = $obMember['idx'];
                    $dues->guinIdx = $_idx;
                    $dues->duesDate = $postVars['duesDate'];
                    $dues->duesPrice = $postVars['duesPrice'];
                    $dues->updated();
                }
            }

            Common::error_loc_msg('/page/guin/'.$postVars['idx'], '수정 되었습니다.');
        } else {
            $_idx = $obj->created();

            $deus = new EntityGuindues();
            $deus->memberIdx = $obMember['idx'];
            $deus->guinIdx = $_idx;
            $deus->duesDate = $postVars['duesDate'];
            $deus->duesPrice = $postVars['duesPrice'];
            $deus->created();

            Common::error_loc_msg('/page/guin', '저장 되었습니다.');
        }

    }

    public static function getViewGuin($idx) {
        $obj = EntityGuin::getGuin('idx='.$idx,'','')->fetchObject(EntityGuin::class);

        $content = View::render('pages/guin', [
            'idx' => $obj->idx,
            'registerNumber' => $obj->registerNumber,
            'guinName' => $obj->guinName,
            'business' => $obj->business,
            'industry' => $obj->industry,
            'postcode' => $obj->postcode,
            'roadAddress' => $obj->roadAddress,
            'jibunAddress' => $obj->jibunAddress,
            'detailAddress' => $obj->detailAddress,
            'extraAddress' => $obj->extraAddress,
            'phoneNumber_1' => $obj->phoneNumber_1,
            'phoneNumber_2' => $obj->phoneNumber_2,
            'joinItemsOptions' => self::getJoinItemsOptions($obj->items),
            'joinDate' => substr($obj->joinDate, 0, 10),
            'duesDate' => substr(Common::getGuinDues($obj->idx)->duesDate, 0, 10) ?? '',
            'duesPrice' => Common::getGuinDues($obj->idx)->duesPrice ?? '',
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
                'text' => $v['registerNumber'],
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

                $gujig_info = EntityGujig::getGujig("idx=".$emp->gujigIdx,"","","*")->fetchObject(EntityGujig::class);

                if ($gujig_info) {
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

    public static function getGuinDownload($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $results = EntityGuin::getGuinSearch($obMember['idx'], $postVars['search_name']);

        $arr = array();
        $i = 0;
        while ($obj = $results->fetchObject(EntityGuin::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['guinName'] = $obj->guinName;
            $arr[$i]['postcode'] = $obj->postcode;
            $arr[$i]['roadAddress'] = $obj->roadAddress;
            $arr[$i]['jibunAddress'] = $obj->jibunAddress;
            $arr[$i]['detailAddress'] = $obj->detailAddress;
            $arr[$i]['extraAddress'] = $obj->extraAddress;
            $arr[$i]['phoneNumber_1'] = $obj->phoneNumber_1;
            $arr[$i]['phoneNumber_2'] = $obj->phoneNumber_2;
            $arr[$i]['items'] = $obj->items;
            $arr[$i]['joinDate'] = $obj->joinDate;
            $arr[$i]['duesDate'] = $obj->duesDate;
            $arr[$i]['duesPrice'] = $obj->duesPrice;
            $arr[$i]['joinStatus'] = $obj->joinStatus;
            $arr[$i]['bigo'] = $obj->bigo;
            $i++;
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);

        $out_put_file_full_name = "구인 정보";

        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A1", "번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B1", "접수번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("C1", "주소");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("D1", "전화번호1");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E1", "전화번호2");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("F1", "항목");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("G1", "가입일");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("H1", "회비납일");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("I1", "회비금액");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("J1", "회원상태");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("K1", "비고");

        foreach ($arr as $k => $v) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("A".$k+2, $k+1);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("B".$k+2, $v['registerNumber']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("C".$k+2, $v['postcode']." ".$v['roadAddress']." ".$v['jibunAddress']." ".$v['detailAddress']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("D".$k+2, $v['phoneNumber_1']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("E".$k+2, $v['phoneNumber_2']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("F".$k+2, $v['items']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("G".$k+2, $v['joinDate']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("H".$k+2, $v['duesDate']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("I".$k+2, $v['duesPrice']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("J".$k+2, $v['joinStatus']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("K".$k+2, $v['bigo']);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $out_put_file_full_name . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public static function getGuinDuesDownload($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $year_ago = date('Y-m',strtotime($postVars['searchDate']."-01"."-1 year"));

        $results = EntityGuin::getGuinLastDuesList($year_ago);

        $arr = array();
        $i = 0;
        while ($obj = $results->fetchObject(EntityGuin::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['guinName'] = $obj->guinName;
            $arr[$i]['postcode'] = $obj->postcode;
            $arr[$i]['roadAddress'] = $obj->roadAddress;
            $arr[$i]['jibunAddress'] = $obj->jibunAddress;
            $arr[$i]['detailAddress'] = $obj->detailAddress;
            $arr[$i]['extraAddress'] = $obj->extraAddress;
            $arr[$i]['phoneNumber_1'] = $obj->phoneNumber_1;
            $arr[$i]['phoneNumber_2'] = $obj->phoneNumber_2;
            $arr[$i]['items'] = $obj->items;
            $arr[$i]['joinDate'] = $obj->joinDate;
            $arr[$i]['duesDate'] = $obj->duesDate;
            $arr[$i]['duesPrice'] = $obj->duesPrice;
            $arr[$i]['joinStatus'] = $obj->joinStatus;
            $arr[$i]['bigo'] = $obj->bigo;
            $i++;
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);

        $out_put_file_full_name = "구인 회비 정보";

        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A1", "번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B1", "접수번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("C1", "주소");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("D1", "전화번호1");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E1", "전화번호2");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("F1", "항목");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("G1", "가입일");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("H1", "회비납일");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("I1", "회비금액");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("J1", "회원상태");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("K1", "비고");

        foreach ($arr as $k => $v) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("A".$k+2, $k+1);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("B".$k+2, $v['registerNumber']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("C".$k+2, $v['postcode']." ".$v['roadAddress']." ".$v['jibunAddress']." ".$v['detailAddress']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("D".$k+2, $v['phoneNumber_1']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("E".$k+2, $v['phoneNumber_2']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("F".$k+2, $v['items']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("G".$k+2, $v['joinDate']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("H".$k+2, $v['duesDate']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("I".$k+2, $v['duesPrice']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("J".$k+2, $v['joinStatus']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("K".$k+2, $v['bigo']);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $out_put_file_full_name . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public static function getGuinDues($request) {

        $content = View::render('pages/guin_dues', [
            'idx'   => '',
            'registerNumber' => '',
            'duesDate' => '',
            'duesPrice' => '',
            'guinLists' => self::getGuinDuesLists(),
            'guinDuesLists' => '',
        ]);

        return parent::getPanel('', $content, 'guin');
    }

    public static function getGuinDuesLists() {
        $now = date("Y-m-d");
        $year_ago = date('Y-m',strtotime($now."-1 year"));
//        $last_day = date("t",strtotime($year_ago));

        $results = EntityGuin::getGuinLastDuesList($year_ago);

        $arr = array();
        $i = 0;

        while ($obj = $results->fetchObject(EntityGuin::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['guinName'] = $obj->guinName;

            $i++;
        }

        $rows = "";
        foreach ($arr as $k => $v) {
            $rows .= View::render('pages/saramListOptions', [
                'idx' => $v['idx'],
                'text' => $v['registerNumber'],
            ]);
        }

        return $rows;
    }
    public static function getViewGujinDues($idx) {
        $obj = EntityGuin::getGuin('idx='.$idx,'','')->fetchObject(EntityGuin::class);

        $content = View::render('pages/guin_dues', [
            'idx' => $obj->idx,
            'registerNumber' => $obj->registerNumber,
            'duesDate' => Common::getGuinDues($obj->idx)->duesDate ?? '',
            'duesPrice' => Common::getGuinDues($obj->idx)->duesPrice ?? '',
            'guinLists' => self::getGuinDuesLists(),
            'guinDuesLists' => self::guinDuesLists($obj->idx),
        ]);

        return parent::getPanel('', $content, 'guin');
    }

    public static function postGuinDues($request) {
        $postVars = $request->getPostVars();

        $obMember = Common::get_manager();

        $duesDate = $postVars['duesDate']." 00:00:00";
        $duesPrice = $postVars['duesPrice'];

        $result = (new Database('guin'))->execute("update `guin` set `duesDate`='{$duesDate}',`duesPrice`={$duesPrice} where `idx`= ".$postVars['idx']);
        $deus = new EntityGuindues();
        $deus->memberIdx = $obMember['idx'];
        $deus->guinIdx = $postVars['idx'];
        $deus->duesDate = $duesDate;
        $deus->duesPrice = $duesPrice;
        $deus->created();

        Common::error_loc_msg('/page/guin_dues/'.$postVars['idx'], '수정 되었습니다.');
    }

    public static function guinDuesLists($guin_idx) {
        if (!empty($guin_idx)) {
            $emp_obj = EntityGuindues::getGuindues("guinIdx=".$guin_idx,'','','*');

            $array = array();
            $i = 0;

            while ($emp = $emp_obj->fetchObject(EntityGuindues::class)) {
                $array[$i]['duesDate'] = $emp->duesDate;
                $array[$i]['duesPrice'] = $emp->duesPrice;
                $array[$i]['created_at'] = $emp->created_at;

                $i++;
            }

            $rows = "";
            foreach ($array as $k => $v) {
                $rows .= View::render('pages/guinDuesList', [
                    'idx' => $k+1,
                    'duesDate' => $v['duesDate'],
                    'duesPrice' => $v['duesPrice'],
                    'created_at' => $v['created_at'],
                ]);
            }
        }

        return $rows;
    }

    public static function getGuinDuesSearch($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $year_ago = date('Y-m',strtotime($postVars['searchDate']."-01"."-1 year"));

        $results = EntityGuin::getGuinLastDuesList($year_ago);

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
