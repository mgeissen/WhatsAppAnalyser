<?php
/**
 * Created by PhpStorm.
 * User: matthias
 * Date: 01.10.17
 * Time: 11:44
 */

class BestDayAnalyser{

    private $days;

    public function __construct(){
        $this->days = array();
    }


    public function analyse($row){
        if(preg_match("/[0-9]{2}.[0-9]{2}.[0-9]{2}/", $row, $hit)){
            if(isset($this->days[$hit[0]])){
                $this->days[$hit[0]]++;
            } else{
                $this->days[$hit[0]] = 1;
            }
        }
    }

    public function getBestDay(): String{
        return array_keys($this->days, max($this->days))[0];
    }

    public function getBestDayCount(): int{
        return max($this->days);
    }

}