<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Agreement
{
    public $idx;
    public $memberIdx;
    public $guinIdx;
    public $business;
    public $guinJibunAddress;
    public $guinPhoneNumber_1;
    public $guinName;

    public $industry;
    public $gujigIdx;
    public $gujigName;
    public $birthdate;
    public $gujigJibunAddress;
    public $gujigPhoneNumber_1;
    public $pay;
    public $wagePayment;
    public $place;
    public $workingHours;
    public $worker;
    public $contractPeriod;
    public $gita;
    public $guinBurden;
    public $guinBurdenPrice;
    public $gujigBurden;
    public $gujigBurdenPrice;


    public $duesDate;
    public $guinDuesPrice;
    public $gujigDuesPrice;
    public $introductionFee;
    public $bigo;
    public $checkDate;
    public $gujigImage;
    public $guinImage;
    public $created_at;

    public function created()
    {
        $this->created_at = date('Y-m-d H:i:s');

        $this->idx = (new Database('agreement'))->insert([
            'memberIdx' => $this->memberIdx,
            'guinIdx' => $this->guinIdx,
            'business' => $this->business,
            'guinJibunAddress' => $this->guinJibunAddress,
            'guinPhoneNumber_1' => $this->guinPhoneNumber_1,
            'guinName' => $this->guinName,
            'industry' => $this->industry,
            'gujigIdx' => $this->gujigIdx,
            'gujigName' => $this->gujigName,
            'birthdate' => $this->birthdate,
            'gujigJibunAddress' => $this->gujigJibunAddress,
            'gujigPhoneNumber_1' => $this->gujigPhoneNumber_1,
            'pay' => $this->pay,
            'wagePayment' => $this->wagePayment,
            'place' => $this->place,
            'workingHours' => $this->workingHours,
            'worker' => $this->worker,
            'contractPeriod' => $this->contractPeriod,
            'gita' => $this->gita,
            'guinBurden' => $this->guinBurden,
            'guinBurdenPrice' => $this->guinBurdenPrice,
            'gujigBurden' => $this->gujigBurden,
            'gujigBurdenPrice' => $this->gujigBurdenPrice,
            'duesDate' => $this->duesDate,
            'guinDuesPrice' => $this->guinDuesPrice,
            'gujigDuesPrice' => $this->gujigDuesPrice,
            'introductionFee' => $this->introductionFee,
            'bigo' => $this->bigo,
            'checkDate' => $this->checkDate,
            'created_at' => $this->created_at,
        ]);

        return $this->idx;
    }

    public static function getAgreement($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('agreement'))->select($where, $order, $limit, $fields);
    }

    public static function setGuinImage($idx, $filePath)
    {
        return (new Database('agreement'))->execute(
            "update agreement set `guinImage`= '".$filePath."' where `idx` = '".$idx."'"
        );
    }

    public static function setGujigImage($idx, $filePath)
    {
        return (new Database('agreement'))->execute(
            "update agreement set `gujigImage`= '".$filePath."' where `idx` = '".$idx."'"
        );
    }
}
