<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Member {

    public $idx;
    public $member_id;
    public $member_name;
    public $member_password;
    public $member_email;
    public $member_phone;
    public $member_compoany;
    public $created_at;

    public static function getMemberByIdx($idx) {
        return self::getMembers('idx ='.$idx)->fetchObject(self::class);
    }

    public static function getMemberById($member_id) {
        return self::getMembers("member_id='".$member_id."'")->fetchObject(self::class);
    }

    public static function getMembers($where = null, $order = null, $limit = null, $fields = '*') {

        return (new Database('member'))->select($where, $order, $limit, $fields);
    }
}