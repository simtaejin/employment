<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use \App\Utils\Common;
use \App\Utils\View;
use \App\Model\Entity\Guin as EntityGuin;
use \App\Model\Entity\Gujig as EntityGujig;
use App\Model\Entity\Employment as EntityEmployment;
use \App\Model\Entity\Gujigdues as EntityGujigdues;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use WilliamCosta\DatabaseManager\Database;

class Gujig extends Page {

    public static function getGujig() {

        $content = View::render('pages/gujig',[
            'idx' => '',
            'registerNumber' => '',
            'gujigName' => '',
            'birthdate' => '',
            'jumin' => '',
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
            'gujigLists' => self::guGujigLists(),
            'guinLists' => '',
        ]);

        return parent::getPanel('', $content, 'gujig');
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

    public static function postGujig($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $obj = new EntityGujig();
        $obj->idx = isset($postVars['idx']) ? $postVars['idx'] : '';
        $obj->memberIdx = $obMember['idx'];
        $obj->registerNumber = $postVars['registerNumber'];
        $obj->gujigName = $postVars['gujigName'];
        $obj->birthdate = $postVars['birthdate'];
        $obj->jumin = $postVars['jumin'];
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

            $dues_obj = Common::getGujigDues($_idx);
            if (empty($dues_obj)) {
                if ($postVars['duesDate'] && $postVars['duesPrice']) {
                    $deus = new EntityGujigdues();
                    $deus->memberIdx = $obMember['idx'];
                    $deus->gujigIdx = $_idx;
                    $deus->duesDate = $postVars['duesDate'];
                    $deus->duesPrice = $postVars['duesPrice'];
                    $deus->created();
                }
            } else {
                if ($postVars['duesDate'] && $postVars['duesPrice']) {
                    $dues = new EntityGujigdues();
                    $dues->idx = $dues_obj->idx;
                    $dues->memberIdx = $obMember['idx'];
                    $dues->gujigIdx = $_idx;
                    $dues->duesDate = $postVars['duesDate'];
                    $dues->duesPrice = $postVars['duesPrice'];
                    $dues->updated();
                }
            }

            Common::error_loc_msg('/page/gujig/'.$postVars['idx'], '수정 되었습니다.');
        } else {
            $_idx = $obj->created();

            $deus = new EntityGujigdues();
            $deus->memberIdx = $obMember['idx'];
            $deus->gujigIdx = $_idx;
            $deus->duesDate = $postVars['duesDate'];
            $deus->duesPrice = $postVars['duesPrice'];
            $deus->created();

            Common::error_loc_msg('/page/gujig', '저장 되었습니다.');
        }
    }

    public static function guGujigLists()
    {
        $gujig_obj = EntityGujig::getGujig('','','');

        $array = array();
        $i = 0;

        while ($emp = $gujig_obj->fetchObject(EntityGujig::class)) {
            if ($emp) {
                $array[$i]['idx'] = $emp->idx;
                $array[$i]['registerNumber'] = $emp->registerNumber;
                $array[$i]['gujigName'] = $emp->gujigName;

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

    public static function getViewGujig($idx) {
        $obj = EntityGujig::getGujig('idx='.$idx,'','')->fetchObject(EntityGujig::class);

        $content = View::render('pages/gujig', [
            'idx' => $obj->idx,
            'registerNumber' => $obj->registerNumber,
            'gujigName' => $obj->gujigName,
            'birthdate' => $obj->birthdate,
            'jumin' => $obj->jumin,
            'postcode' => $obj->postcode,
            'roadAddress' => $obj->roadAddress,
            'jibunAddress' => $obj->jibunAddress,
            'detailAddress' => $obj->detailAddress,
            'extraAddress' => $obj->extraAddress,
            'phoneNumber_1' => $obj->phoneNumber_1,
            'phoneNumber_2' => $obj->phoneNumber_2,
            'joinItemsOptions' => self::getJoinItemsOptions($obj->items),
            'joinDate' => substr($obj->joinDate, 0, 10),
            'duesDate' => substr(Common::getGujigDues($obj->idx)->duesDate, 0, 10) ?? '',
            'duesPrice' => Common::getGujigDues($obj->idx)->duesPrice ?? '',
            'joinStatusOptions' => self::getJoinStatusOptions($obj->joinStatus),
            'bigo' => strip_tags($obj->bigo),
            'gujigLists' => self::guGujigLists(),
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

                $guin_info = EntityGuin::getGuin('idx='.$emp->guinIdx,'','')->fetchObject(EntityGuin::class);

                if ($guin_info) {
                    $array[$i]['registerNumber'] = $guin_info->registerNumber;
                    $array[$i]['guinName'] = $guin_info->guinName;
                    $array[$i]['roadAddress'] = $guin_info->roadAddress;
                    $array[$i]['detailAddress'] = $guin_info->detailAddress;
                    $array[$i]['phoneNumber_1'] = $guin_info->phoneNumber_1;
                    $array[$i]['phoneNumber_2'] = $guin_info->phoneNumber_2;
                    $array[$i]['applicationTime'] = $emp->applicationTime;
                    $array[$i]['applicationDate'] = $emp->applicationDate;

                    $i++;
                }

            }

            $rows = "";
            foreach ($array as $k => $v) {
                $rows .= View::render('pages/guinList', [
                    'idx' => $k+1,
                    'registerNumber' => $v['registerNumber'],
                    'guinName' => $v['guinName'],
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

    public static function getGujigDownload($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $results = EntityGujig::getGujigSearch($obMember['idx'], $postVars['search_name']);

        $arr = array();
        $i = 0;
        while ($obj = $results->fetchObject(EntityGujig::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['gujigName'] = $obj->gujigName;
            $arr[$i]['jumin'] = $obj->jumin;
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

        $out_put_file_full_name = "구직 정보";

        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A1", "번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B1", "접수번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("C1", "주민번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("D1", "주소");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E1", "전화번호1");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("F1", "전화번호2");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("G1", "항목");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("H1", "가입일");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("I1", "회비납일");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("J1", "회비금액");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("K1", "회원상태");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("L1", "비고");

        foreach ($arr as $k => $v) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("A".$k+2, $k+1);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("B".$k+2, $v['registerNumber']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("C".$k+2, $v['jumin']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("D".$k+2, $v['postcode']." ".$v['roadAddress']." ".$v['jibunAddress']." ".$v['detailAddress']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("E".$k+2, $v['phoneNumber_1']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("F".$k+2, $v['phoneNumber_2']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("G".$k+2, $v['items']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("H".$k+2, $v['joinDate']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("I".$k+2, $v['duesDate']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("J".$k+2, $v['duesPrice']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("K".$k+2, $v['joinStatus']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("L".$k+2, $v['bigo']);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $out_put_file_full_name . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public static function getGujigDuesDownload($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $year_ago = date('Y-m',strtotime($postVars['searchDate']."-01"."first day of 1 months ago"));

        $results = EntityGujig::getGujigLastDuesList($year_ago);

        $arr = array();
        $i = 0;
        while ($obj = $results->fetchObject(EntityGujig::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['gujigName'] = $obj->gujigName;
            $arr[$i]['jumin'] = $obj->jumin;
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

        $out_put_file_full_name = "구직 회비 정보";

        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A1", "번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B1", "접수번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("C1", "주민번호");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("D1", "주소");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E1", "전화번호1");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("F1", "전화번호2");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("G1", "항목");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("H1", "가입일");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("I1", "회비납일");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("J1", "회비금액");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("K1", "회원상태");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("L1", "비고");

        foreach ($arr as $k => $v) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("A".$k+2, $k+1);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("B".$k+2, $v['registerNumber']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("C".$k+2, $v['jumin']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("D".$k+2, $v['postcode']." ".$v['roadAddress']." ".$v['jibunAddress']." ".$v['detailAddress']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("E".$k+2, $v['phoneNumber_1']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("F".$k+2, $v['phoneNumber_2']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("G".$k+2, $v['items']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("H".$k+2, $v['joinDate']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("I".$k+2, $v['duesDate']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("J".$k+2, $v['duesPrice']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("K".$k+2, $v['joinStatus']);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue("L".$k+2, $v['bigo']);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $out_put_file_full_name . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public static function getGujigDues($request) {
        $content = View::render('pages/gujig_dues', [
            'idx'   => '',
            'registerNumber' => '',
            'duesDate' => '',
            'duesPrice' => '',
            'gujigLists' => self::getGujigDuesLists(),
            'gujigDuesLists' => '',
        ]);

        return parent::getPanel('', $content, 'gujig');
    }

    public static function getGujigDuesLists() {
        $now = date("Y-m-d");
        $year_ago = date('Y-m',strtotime($now."first day of 1 months ago"));
//        $last_day = date("t",strtotime($year_ago));

        $results = EntityGujig::getGujigLastDuesList($year_ago);
        $arr = array();
        $i = 0;

        while ($obj = $results->fetchObject(EntityGujig::class)) {
            $arr[$i]['idx'] = $obj->idx;
            $arr[$i]['registerNumber'] = $obj->registerNumber;
            $arr[$i]['gujigName'] = $obj->gujigName;

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

    public static function getViewGujigDues($idx) {
        $obj = EntityGujig::getGujig('idx='.$idx,'','')->fetchObject(EntityGujig::class);

        $content = View::render('pages/gujig_dues', [
            'idx' => $obj->idx,
            'registerNumber' => $obj->registerNumber,
            'duesDate' => Common::getGujigDues($obj->idx)->duesDate ?? '',
            'duesPrice' => Common::getGujigDues($obj->idx)->duesPrice ?? '',
            'gujigLists' => self::getGujigDuesLists(),
            'gujigDuesLists' => self::gujigDuesLists($obj->idx),
        ]);

        return parent::getPanel('', $content, 'gujig');
    }

    public static function postGujigDues($request) {
        $postVars = $request->getPostVars();

        $obMember = Common::get_manager();

        $duesDate = $postVars['duesDate']." 00:00:00";
        $duesPrice = $postVars['duesPrice'];

        $result = (new Database('gujig'))->execute("update `gujig` set `duesDate`='{$duesDate}',`duesPrice`={$duesPrice} where `idx`= ".$postVars['idx']);
        $deus = new EntityGujigdues();
        $deus->memberIdx = $obMember['idx'];
        $deus->gujigIdx = $postVars['idx'];
        $deus->duesDate = $duesDate;
        $deus->duesPrice = $duesPrice;
        $deus->created();

        Common::error_loc_msg('/page/gujig_dues/'.$postVars['idx'], '수정 되었습니다.');
    }

    public static function gujigDuesLists($gujig_idx) {
        if (!empty($gujig_idx)) {
            $emp_obj = EntityGujigdues::getGujigdues("gujigIdx=".$gujig_idx,'','','*');

            $array = array();
            $i = 0;

            while ($emp = $emp_obj->fetchObject(EntityGujigdues::class)) {
                $array[$i]['duesDate'] = $emp->duesDate;
                $array[$i]['duesPrice'] = $emp->duesPrice;
                $array[$i]['created_at'] = $emp->created_at;

                $i++;
            }

            $rows = "";
            foreach ($array as $k => $v) {
                $rows .= View::render('pages/gujigDuesList', [
                    'idx' => $k+1,
                    'duesDate' => $v['duesDate'],
                    'duesPrice' => $v['duesPrice'],
                    'created_at' => $v['created_at'],
                ]);
            }
        }

        return $rows;
    }

    public static function getGujigDuesSearch($request) {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $year_ago = date('Y-m',strtotime($postVars['searchDate']."-01"."first day of 1 months ago"));

        $results = EntityGujig::getGujigLastDuesList($year_ago);

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
