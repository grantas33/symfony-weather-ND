<?php
/**
 * Created by PhpStorm.
 * User: grantas
 * Date: 18.4.13
 * Time: 12.33
 */

namespace App\Weather;


use DateTime;

class ValidationService
{
    /**
     * @param $day
     * @throws \Exception
     */
    public function validateWeatherByDay($day)
    {
        if(!$day) return;
        $d = DateTime::createFromFormat('Y-m-d', $day);
        if($d == false){
            throw new \Exception("Bad date format");
        }
        if(!($d && $d->format('Y-m-d') == $day)){
            throw new \Exception("Invalid date");
        }

        if($d < new DateTime('now')){
            throw new \Exception("Date is in the past!");
        }

        $future_date = new DateTime('now');
        $future_date->add(new \DateInterval('P2M'));
        if($d > $future_date){
            throw new \Exception("Date is more than two months in the future!");
        }

    }
}