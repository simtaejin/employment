<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

#[\AllowDynamicProperties]
class OldGuin
{
    public $idx;
    public $registrationNo; // 등록번호
    public $employerName;   // 구인자명
    public $contactNo;      // 연락처
    public $address;        // 주소
    public $receptionDate;  // 접수일자
    public $remarks;        // 비고


    public static function OldGuin($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('old_guin'))->select($where, $order, $limit, $fields);
    }

    public function created()
    {
        $this->idx = (new Database('old_guin'))->insert([
            'registration_no' => $this->registrationNo,
            'employer_name' => $this->employerName,
            'contact_no' => $this->contactNo,
            'address' => $this->address,
            'reception_date' => $this->receptionDate,
            'remarks' => $this->remarks,
        ]);

        return $this->idx;
    }
}
