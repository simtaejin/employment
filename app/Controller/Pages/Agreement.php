<?php

namespace App\Controller\Pages;

use \App\Controller\Pages\Page;

use \App\Utils\Common;
use \App\Utils\View;
use \App\Model\Entity\Agreement as EntityAgreement;

class Agreement extends Page
{
    public static function getAgreementList()
    {
        $agreement_obj = EntityAgreement::getAgreement("", "", "", "*");

        $array = array();
        $i = 0;

        while ($obj = $agreement_obj->fetchObject(EntityAgreement::class)) {
            $array[$i]['idx'] = $obj->idx;
            $array[$i]['business'] = $obj->business;
            $array[$i]['guinName'] = $obj->guinName;
            $array[$i]['guinJibunAddress'] = $obj->guinJibunAddress;
            $array[$i]['gujigPhoneNumber_1'] = $obj->gujigPhoneNumber_1;
            $array[$i]['gujigName'] = $obj->gujigName;
            $array[$i]['pay'] = $obj->pay;
            $i++;
        }


        $rows = "";
        foreach ($array as $k => $v) {
            $rows .= View::render('pages/agreementListTr', [
                'idx' => $v['idx'],
                'business' => $v['business'],
                'guinName' => $v['guinName'],
                'guinJibunAddress' => $v['guinJibunAddress'],
                'gujigPhoneNumber_1' => $v['gujigPhoneNumber_1'],
                'gujigName' => $v['gujigName'],
                'pay' => $v['pay'],
            ]);
        }


        $content = View::render('pages/agreementList', [
            'rows' => $rows,
        ]);

        return parent::getPanel('', $content, 'agreement');
    }

    public static function getAgreementCreate()
    {
        $content = View::render('pages/agreementCreate', []);

        return parent::getPanel('', $content, 'agreement');
    }

    public static function getAgreementSave($request)
    {
        $postVars = $request->getPostVars();
        $obMember = Common::get_manager();

        $obj = new EntityAgreement();

        $obj->memberIdx = 1;
        $obj->guinIdx = 1;
        $obj->business = $postVars['business'];
        $obj->guinJibunAddress = $postVars['guinJibunAddress'];
        $obj->guinPhoneNumber_1 = $postVars['guinPhoneNumber_1'];
        $obj->guinName = $postVars['guinName'];
        $obj->industry = $postVars['industry'];
        $obj->gujigIdx = 1;
        $obj->gujigName = $postVars['gujigName'];
        $obj->birthdate = $postVars['birthdate'];
        $obj->gujigJibunAddress = $postVars['gujigJibunAddress'];
        $obj->gujigPhoneNumber_1 = $postVars['gujigPhoneNumber_1'];
        $obj->pay = $postVars['pay'];
        $obj->wagePayment = $postVars['wagePayment'];
        $obj->place = $postVars['place'];
        $obj->workingHours = $postVars['workingHours'];
        $obj->worker = $postVars['worker'];
        $obj->contractPeriod = $postVars['contractPeriod'];
        $obj->gita = $postVars['gita'];
        $obj->guinBurden = $postVars['guinBurden'];
        $obj->guinBurdenPrice = $postVars['guinBurdenPrice'];
        $obj->gujigBurden = $postVars['gujigBurden'];
        $obj->gujigBurdenPrice = $postVars['gujigBurdenPrice'];
        $obj->duesDate = $postVars['duesDate'];
        $obj->guinDuesPrice = $postVars['guinDuesPrice'];
        $obj->gujigDuesPrice = $postVars['gujigDuesPrice'];
        $obj->introductionFee = $postVars['introductionFee'];
        $obj->checkDate = $postVars['checkDate'].' 00:00:00';
        $obj->bigo = $postVars['bigo'];
        $_idx = $obj->created();

    }

    public static function getAgreementView($idx)
    {

        $agreement_obj = EntityAgreement::getAgreement("idx=".$idx, "", "", "*");
        $obj = $agreement_obj->fetchObject(EntityAgreement::class);

        foreach (get_object_vars($obj) as $property => $value) {
            if ($property == 'business') {
                $$property = $value;
            } else if ($property == 'checkDate') {
                $checkDateY = substr($value, 0, 4);
                $checkDateM = substr($value, 5, 2);
                $checkDateD = substr($value, 8, 2);
            } else {
                $$property = $value;
            }
        }
        $array = array_merge(
            get_object_vars($obj),
            [
                'checkDateY' => $checkDateY ?? null,
                'checkDateM' => $checkDateM ?? null,
                'checkDateD' => $checkDateD ?? null
            ]
        );

        $content = View::render('pages/agreementView', $array);
        return parent::getBlankPanel('', $content, 'agreement');
    }
}
