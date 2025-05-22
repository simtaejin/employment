<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;
use \App\Utils\Common;
use \App\Utils\View;
use \App\Model\Entity\OldGujig as EntityOldGujig;
use \App\Model\Entity\OldGuin as EntityOldGuin;


class OldPage extends Page
{
    public static function getOldGujig($request)
    {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $results = EntityOldGujig::getOldGujig('', '', '', '*');

        $array = array();
        $i = 0;
        while ($obj = $results->fetchObject(EntityOldGujig::class)) {

            $array[$i]['reception_no'] = $obj->reception_no;              // 접수번호
            $array[$i]['name'] = $obj->name;                             // 성명
            $array[$i]['ssn'] = $obj->ssn;                               // 주민등록번호
            $array[$i]['age'] = $obj->age;                               // 나이
            $array[$i]['reception_date'] = $obj->reception_date;          // 접수일자
            $array[$i]['contact_no'] = $obj->contactNo;                  // 연락처
            $array[$i]['desired_job'] = $obj->desiredJob;                // 희망직종
            $array[$i]['address'] = $obj->address;                       // 주소
            $array[$i]['remarks'] = $obj->remarks;                       // 비고
            $array[$i]['member_type'] = $obj->memberType;                // 회원구분
            $array[$i]['nationality_status'] = $obj->nationality_status;  // 내/외국인
            $array[$i]['health_certificate'] = $obj->health_certificate;  // 보건증
            $i++;
        }

        $rows = "";
        foreach ($array as $k => $v) {
            $rows .= View::render('pages/oldGujigListTr', [
                'idx' => $k + 1,
                'reception_no' => $v['reception_no'],              // 접수번호
                'name' => $v['name'],                             // 성명
                'ssn' => $v['ssn'],                               // 주민등록번호
                'age' => $v['age'],                               // 나이
                'reception_date' => $v['reception_date'],          // 접수일자
                'contact_no' => $v['contact_no'],                  // 연락처
                'desired_job' => $v['desired_job'],                // 희망직종
                'address' => $v['address'],                       // 주소
                'remarks' => $v['remarks'],                       // 비고
                'member_type' => $v['member_type'],                // 회원구분
                'nationality_status' => $v['nationality_status'],  // 내/외국인
                'health_certificate' => $v['health_certificate'],  // 보건증
            ]);
        }

        $content = View::render('pages/oldGujigList', [
            'oldGujigListTr' => $rows,
        ]);

        return parent::getPanel('', $content, 'oldpage');
    }

public static function getOldGuin($request)
{
    $postVars = $request->getPostVars();
    $obMember = Common::get_manager();

    $results = EntityOldGuin::OldGuin('', '', '', '*');

    $array = array();
    $i = 0;
    while ($obj = $results->fetchObject(EntityOldGuin::class)) {

        $array[$i]['registration_no'] = $obj->registration_no;  // 등록번호
        $array[$i]['employer_name'] = $obj->employer_name;      // 구인자명
        $array[$i]['contact_no'] = $obj->contact_no;            // 연락처
        $array[$i]['address'] = $obj->address;                 // 주소
        $array[$i]['reception_date'] = $obj->reception_date;    // 접수일자
        $array[$i]['remarks'] = $obj->remarks;                 // 비고
        $i++;
    }

    $rows = "";
    foreach ($array as $k => $v) {
        $rows .= View::render('pages/oldGuinListTr', [
            'idx' => $k + 1,
            'registration_no' => $v['registration_no'],  // 등록번호
            'employer_name' => $v['employer_name'],      // 구인자명
            'contact_no' => $v['contact_no'],            // 연락처
            'address' => $v['address'],                  // 주소
            'reception_date' => $v['reception_date'],    // 접수일자
            'remarks' => $v['remarks'],                 // 비고
        ]);
    }

    $content = View::render('pages/oldGuinList', [
        'oldGuinListTr' => $rows,
    ]);

    return parent::getPanel('', $content, 'oldpage');
}

}
