<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Guindues
{
    public $idx;
    public $memberIdx;
    public $guinIdx;
    public $duesDate;
    public $duesPrice;
    public $created_at;

    public static function getLastDues($idx)
    {
        return (new Database('guin_dues'))->execute(
            "select *  from guin_dues where (idx) in (select max(idx) as idx from guin_dues where memberIdx='1' and guinIdx=".$idx." group by guinIdx)"
        );
    }

    public static function getGuindues($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('guin_dues'))->select($where, $order, $limit, $fields);
    }

    public function created()
    {
        $this->created_at = date('Y-m-d H:i:s');

        $this->idx = (new Database('guin_dues'))->insert([
            'memberIdx' => $this->memberIdx,
            'guinIdx' => $this->guinIdx,
            'duesDate' => $this->duesDate,
            'duesPrice' => $this->duesPrice,
            'created_at' => $this->created_at,
        ]);

        return $this->idx;
    }

    public function updated()
    {
        $this->idx = (new Database('guin_dues'))->update('idx ='.$this->idx,[
            'memberIdx' => $this->memberIdx,
            'guinIdx' => $this->guinIdx,
            'duesDate' => $this->duesDate,
            'duesPrice' => $this->duesPrice,
        ]);
    }
}