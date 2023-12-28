<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Employment
{
    public $idx;

    public $memberIdx;

    public $guinIdx;

    public $gujigIdx;

    public $applicationDate;

    public $applicationTime;

    public $created_at;

    public static function getEmployment($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('employment '))->select($where, $order, $limit, $fields);
    }

    public function created()
    {
        $this->created_at = date('Y-m-d H:i:s');

        $this->idx = (new Database('employment'))->insert([
            'memberIdx' => $this->memberIdx,
            'guinIdx' => $this->guinIdx,
            'gujigIdx' => $this->gujigIdx,
            'applicationDate' => $this->applicationDate,
            'applicationTime' => $this->applicationTime,
            'created_at' => $this->created_at,
        ]);

        return $this->idx;
    }
}