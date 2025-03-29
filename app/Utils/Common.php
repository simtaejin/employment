<?php
namespace App\Utils;


use App\Model\Entity\Agreement as EntityAgreement;
use App\Model\Entity\Member as EntityMmeber;
use Exception;
use \App\Model\Entity\Guindues as EntityGuindues;
use \App\Model\Entity\Gujigdues as EntityGujigdues;


class Common{

    private static $vars = [];

    public static function init($vars = []) {
        self::$vars = $vars;
    }


    public static function print_r2($vars) {
        echo "<pre>";
        print_r($vars);
        echo "<pre>";
        exit;
    }

    public static function var_dump2($vars) {
        echo "<pre>";
        var_dump($vars);
        echo "<pre>";
        exit;
    }


    public static function str_chekc($str, $msg) {

        if (!isset($str) || empty($str)) {
            self::error_msg($msg);
            exit;
        }

        return $str;
    }

    public static function int_check($int, $msg) {

        if (!is_numeric($int)) {
            self::error_msg($msg);
            exit;
        }

        return $int;
    }

    public static function get_member_info($idx) {
        $obj = (array) EntityMmeber::getMemberByIdx($idx);

        return $obj;
    }

    public static function get_manager() {
        if (!$_SESSION['user']) return null;

        return $_SESSION['user'];
    }

    public static function getInterval($key = '') {
        if ($key) {
            $interval = array(
                "PT1M" => "1",
                "PT5M" => "5",
                "PT10M" => "10",
                "PT30M" => "30",
                "PT60M" => "60",
            );

            $interval = $interval[$key];
        } else {
            $interval = array(
                "PT1M" => "1분",
                "PT5M" => "5분",
                "PT10M" => "10분",
                "PT30M" => "30분",
                "PT60M" => "1시간",
            );
        }
        return $interval;
    }


    // TODO : date_range
    /**
     *
     * @param $startDate
     * @param $lastDate
     * @return array|string
     *
     * getDatesStartToLast("2020-09-25", "2020-09-25")
     */
    public static function getDatesStartToLast($startDate, $lastDate) {
        $regex = "/^\d{4}-(0[1-9]|1[012])-(0[1-9]|[12][0-9]|3[0-1])$/";
        if(!(preg_match($regex, $startDate) && preg_match($regex, $lastDate))) return "Not Date Format";
        $period = new DatePeriod( new DateTime($startDate), new DateInterval('PT1M'), new DateTime($lastDate." +1 day"));
        foreach ($period as $date) $dates[] = $date->format("Y-m-d H:i:s");
        return $dates;
    }

    public static function date_range($first, $last, $step = '+1 day', $output_format = 'd/m/Y' )  {
        $dates = array();
        $current = strtotime($first);
        $last = strtotime($last);

        while( $current <= $last ) {
            //$dates[] = date($output_format, $current);
            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }



    public static function error_msg($msg) {
        echo "<script language='javascript'>alert('$msg');history.back();</script>";
        exit;
    }

    public static function error_loc_msg($loc, $msg, $target=null)  {
        if($target) { echo "<script language='javascript'>alert('$msg');".$target.".location.href=('${loc}');</script>"; }
        else { echo "<script language='javascript'>alert('$msg');location.href=('${loc}');</script>"; }
        exit;
    }

    public static function getGuinDues($guin_idx=0) {
        if ($guin_idx==0) return null;

        $dues_obj = EntityGuindues::getLastDues($guin_idx);
        $dues = $dues_obj->fetchObject();
        return $dues;
    }

    public static function getGujigDues($gujig_idx=0) {
        if ($gujig_idx==0) return null;

        $dues_obj = EntityGujigdues::getLastDues($gujig_idx);
        $dues = $dues_obj->fetchObject();
        return $dues;
    }

    public static function getAgreement($idx=0) {
        if ($idx==0) return null;

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

        return $array;
    }

}
