<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;
#[\AllowDynamicProperties]
class OldGujig
{
    public $idx;
    public $receptionNo;         // 접수번호 (VARCHAR(20)): PRIMARY KEY, 고유한 접수 번호
    public $name;                // 성명 (VARCHAR(50)): 지원자의 이름
    public $ssn;                 // 주민번호 (VARCHAR(14)): 주민등록번호
    public $age;                 // 나이 (INT): 지원자의 나이
    public $receptionDate;       // 접수일자 (DATE): 지원 서류의 접수 날짜
    public $contactNo;           // 연락처 (VARCHAR(15)): 지원자의 연락처
    public $desiredJob;          // 희망직종 (VARCHAR(100)): 지원자가 희망하는 직종
    public $postalCode;          // 우편번호 (VARCHAR(10)): 지원자의 우편번호
    public $address;             // 주소 (VARCHAR(255)): 지원자의 상세 주소
    public $remarks;             // 비고 (TEXT): 추가적인 메모 또는 비고 사항
    public $infoDisclosure;      // 정보공개 (VARCHAR(10)): 정보 공개 여부
    public $memberType;          // 회원구분 (VARCHAR(20)): 지원자의 회원 구분 (예: 정회원, 준회원 등)
    public $nationalityStatus;   // 내/외국인 (VARCHAR(10)): 지원자가 내국인인지 외국인인지
    public $bankAccount;         // 은행계좌 (VARCHAR(30)): 지원자의 은행 계좌 정보
    public $foreignName;         // 외국인명 (VARCHAR(50)): 외국인의 이름 (영문 또는 원어)
    public $residencyExpiry;     // 체류만료일 (DATE): 외국인의 체류 허가 만료일
    public $country;             // 국적 (VARCHAR(50)): 지원자의 국가 (국적)
    public $visaType;            // 비자 (VARCHAR(10)): 외국인의 비자 유형
    public $healthCertificate;   // 보건증 (VARCHAR(10)): 보건증 소유 여부
    public $healthCertExpiry;    // 보건증만료일 (DATE): 보건증의 유효 만료일



    public static function getOldGujig($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('old_gujig'))->select($where, $order, $limit, $fields);
    }


    public function created()
    {
        $this->idx = (new Database('old_gujig'))->insert([
            'reception_no' => $this->receptionNo,
            'name' => $this->name,
            'ssn' => $this->ssn,
            'age' => $this->age,
            'reception_date' => $this->receptionDate,
            'contact_no' => $this->contactNo,
            'desired_job' => $this->desiredJob,
            'postal_code' => $this->postalCode,
            'address' => $this->address,
            'remarks' => $this->remarks,
            'info_disclosure' => $this->infoDisclosure,
            'member_type' => $this->memberType,
            'nationality_status' => $this->nationalityStatus,
            'bank_account' => $this->bankAccount,
            'foreign_name' => $this->foreignName,
            'residency_expiry' => $this->residencyExpiry,
            'country' => $this->country,
            'visa_type' => $this->visaType,
            'health_certificate' => $this->healthCertificate,
            'health_cert_expiry' => $this->healthCertExpiry,
        ]);

        return $this->idx;
    }


}
