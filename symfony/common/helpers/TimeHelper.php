<?php
namespace common\helpers;

use Yii;
use common\web\BaseController;
use yii\helpers\ArrayHelper;

class TimeHelper{

    public static function timeHelper($workoutid)//get hours
    {
        $minutesumm = [];
        $hoursumm = [];
        foreach ($workoutid as $key => $value) {
            if ( $value['hours'] != null ){
                $minute = Yii::$app->formatter->format($value['hours'], ['time', 'm']);
                $minutesumm[] = (Yii::$app->formatter->format($minute, 'decimal')*100/60)/100;

                $hour = Yii::$app->formatter->format($value['hours'], ['time', 'h']);
                $hoursumm[] = Yii::$app->formatter->format($hour, 'decimal');
            }
        }
        $percent = array_sum($hoursumm) + round(array_sum($minutesumm)*100*60/100/60);
        $time = array_sum($hoursumm) + round(array_sum($minutesumm)*100*60/100/60) . 'h' . (array_sum($minutesumm)*100*60/100 - round(array_sum($minutesumm)*100*60/100/60)*60) . 'm';
        return [$time, $percent];
    }

    public static function monthHoursmax($days){
        $month_max = $days * 6;
        return $month_max;
    }
}
