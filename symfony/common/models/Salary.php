<?php
namespace common\models;
use Yii;
use DateTime;
use DatePeriod;
use DateInterval;

use understeam\calendar\ItemInterface;
use yii\base\Model;
use yii\helpers\ArrayHelper;

use common\models\UserBalance;
use common\models\Workout;
use common\models\WorkoutTransactions;
use common\models\Project;
use common\models\Holidays;

use understeam\calendar\ActiveRecordItemTrait;

class Salary extends Model
{
    public $date;
    public $hour;
    public $salary_usd;
    public $salary_uah;
    public $transaction;

    static function getMonth(){

        $month = [
            '1'    => 'January',
            '2'    => 'February',
            '3'    => 'March',
            '4'    => 'April',
            '5'    => 'May',
            '6'    => 'June',
            '7'    => 'July',
            '8'    => 'August',
            '9'    => 'September',
            '10'   => 'October',
            '11'   => 'November',
            '12'   => 'December'
        ];
        return $month;
    }

    public static function getWeekDays($year, $monthnumber){
        $week_days = ['Sun' ,'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        $first_day = new DateTime( $year . '-' . $monthnumber . '-01');
        $period = new DatePeriod($first_day, new DateInterval('P1D'), $first_day->format('t') - 1);
        $month_days = [];

        foreach ($period as $index => $day) {
            $month_days[] = sprintf( $week_days[$day->format('w')], $day->format('j'));
        }
        return $month_days;
    }

    public static function getMonthvsHollidays($monthnumber){
        $holidays_year = Holidays::find()->all();
        $holidays = ArrayHelper::map(ArrayHelper::toArray($holidays_year), 'day', 'id', 'month');
        $holidays_all = [];
        foreach ($holidays as $key => $value) {
            $holidays_all[$key] = array_keys($holidays[$key]);
        }
        $month_name = Salary::getMonth()[$monthnumber];

        if ($holidays_all != NULL){
            if (in_array($month_name, $holidays_all)){
                foreach ($holidays_all[$month_name] as $key => $value) {
                    foreach ($days as $key1 => $value1) {
                        $days[$value] = 0;
                    }
                }
                return $days;
            }
        }
    }

    public static function getDaysAmount($monthnumber, $year){
        $number = date('t', mktime(0, 0, 0, $monthnumber, 1, $year));
        return $number;
    }

    public static function getCurrentMonth(){
        $monthnumber = Yii::$app->formatter->asDate(time(), 'M');
        return $monthnumber;
    }

    public static function getMonthMax($days_week){
        foreach ($days_week as $key => $value) {
               if ($value == 'Sat' || $value == 'Sun'){
                   unset($days_week[$key]);
               }
           }
        return $days_week;
    }

    public static function getCurrentYear(){
        $year = Yii::$app->formatter->asDate(time(), 'yyyy');
        return $year;
    }

    public static function getHourlyMonth($days, $number, $month_number, $year, $id = Null){
        if ($id != Null){
            $user_id = $id;
        }else{
            $user_id = Yii::$app->user->id;
        }
        // $last_month_day = Salary::getDaysAmount($month_number, $year);
        $first_day = Yii::$app->formatter->format($year . '-' . $month_number . '-01', 'timestamp');
        $last_day = Yii::$app->formatter->format($year . '-' . $month_number . '-' . $number, 'timestamp');

        for ($k = 0; $k < $number; $k++){
            $days[] = $k;
        }
        $days = array_fill(0, $number, 0);
        $workout = Workout::find()->where(['user_id' => $user_id])
            ->andWhere(['>=', 'workout_date', $first_day])
            ->andWhere(['<=', 'workout_date', $last_day])->all();
        $workout_data = ArrayHelper::toArray($workout);

        if($workout_data != Null){
            foreach ($workout_data as $key => $value) {
                $workout_by_month[$value['workout_date']] = $value['hours'];
            }

            foreach ($workout_by_month as $key => $value) {

                if($value != Null){
                    $days[Yii::$app->formatter->asDate($key, 'd')] = explode(':', $value)['0'] * 60 + explode(':', $value)['1'];
                }else{
                    $days[Yii::$app->formatter->asDate($key, 'd')] = 0;
                }
            }
        }else{
            $days = null;
        }
        return $days;
    }
}
