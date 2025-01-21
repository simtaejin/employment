<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Gujigdues
{
    public $idx;
    public $memberIdx;
    public $gujigIdx;
    public $duesDate;
    public $duesPrice;
    public $created_at;

    public static function getLastDues($idx)
    {
        return (new Database('gujig_dues'))->execute(
            "select *  from gujig_dues where (idx) in (select max(idx) as idx from gujig_dues where memberIdx='1' and gujigIdx=".$idx." group by gujigIdx)"
        );
    }
    public static function getGujigdues($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('gujig_dues'))->select($where, $order, $limit, $fields);
    }
    public function created()
    {
        $this->created_at = date('Y-m-d H:i:s');

        $this->idx = (new Database('gujig_dues'))->insert([
            'memberIdx' => $this->memberIdx,
            'gujigIdx' => $this->gujigIdx,
            'duesDate' => $this->duesDate,
            'duesPrice' => $this->duesPrice,
            'created_at' => $this->created_at,
        ]);

        return $this->idx;
    }

    public function updated()
    {
        $this->idx = (new Database('gujig_dues'))->update('idx ='.$this->idx,[
            'memberIdx' => $this->memberIdx,
            'gujigIdx' => $this->gujigIdx,
            'duesDate' => $this->duesDate,
            'duesPrice' => $this->duesPrice,
        ]);
    }
}