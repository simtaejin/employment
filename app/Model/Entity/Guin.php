<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Guin
{

    public $idx;

    public $memberIdx;

    public $registerNumber;

    public $guinName;

    public $postcode;

    public $roadAddress;

    public $jibunAddress;

    public $detailAddress;

    public $extraAddress;

    public $phoneNumber_1;

    public $phoneNumber_2;

    public $created_at;


    public static function getGuinSearch($idx, $name)
    {
        return (new Database('guin'))->execute("select * from guin where memberIdx='{$idx}' and guinName like '%{$name}%' ");
    }

    public static function getGuin($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('guin'))->select($where, $order, $limit, $fields);
    }

    public function created()
    {
        $this->created_at = date('Y-m-d H:i:s');

        $this->idx = (new Database('guin'))->insert([
            'memberIdx' => $this->memberIdx,
            'registerNumber' => $this->registerNumber,
            'guinName' => $this->guinName,
            'postcode' => $this->postcode,
            'roadAddress' => $this->roadAddress,
            'jibunAddress' => $this->jibunAddress,
            'detailAddress' => $this->detailAddress,
            'extraAddress' => $this->extraAddress,
            'phoneNumber_1' => $this->phoneNumber_1,
            'phoneNumber_2' => $this->phoneNumber_2,
            'created_at' => $this->created_at,
        ]);

        return $this->idx;
    }

    public function updated()
    {
        $this->idx = (new Database('guin'))->update('idx ='.$this->idx,[
            'memberIdx' => $this->memberIdx,
            'registerNumber' => $this->registerNumber,
            'guinName' => $this->guinName,
            'postcode' => $this->postcode,
            'roadAddress' => $this->roadAddress,
            'jibunAddress' => $this->jibunAddress,
            'detailAddress' => $this->detailAddress,
            'extraAddress' => $this->extraAddress,
            'phoneNumber_1' => $this->phoneNumber_1,
            'phoneNumber_2' => $this->phoneNumber_2,
        ]);
    }
}