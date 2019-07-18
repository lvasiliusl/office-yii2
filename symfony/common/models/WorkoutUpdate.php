<?php
namespace common\models;
use Yii;
// use DateTime;

// use yii\filters\AccessControl;
// use common\web\BaseController;
//
// use common\models\User;
// use common\models\Project;
use yii\base\Model;

use common\models\Workout;
// use common\models\Currency;
// use common\models\OfficeBalance;
// use common\models\WorkoutTransactions;
// use common\models\CurrencyExchange;
// use yii\helpers\ArrayHelper;
// use common\models\Salary;
// use common\models\UserBalance;
// use common\helpers\TimeHelper;


    class WorkoutUpdate extends Workout{

        public $hours_h;
        public $hours_m;
        public $rate;
        public $rate_type;
        public $fixed;
        public $description;
        public $project_id;
        public $workout_date;
        public $user_id;
        public $currency_id;

        function __construct($parameter){

            $workout = Workout::findOne($parameter);

            if ($workout->rate_type === 'hourly'){
                $this->hours_h = explode(':', $workout->hours)['0'];
                $this->hours_m = explode(':', $workout->hours)['1'];
            }
            $this->rate = $workout->rate;
            $this->rate_type = $workout->rate_type;
            $this->fixed = Yii::$app->formatter->asDecimal($workout->fixed);
            $this->description = $workout->description;
            $this->project_id = $workout->project_id;
            $this->workout_date = $workout->workout_date;
            $this->user_id = $workout->user_id;
            $this->currency_id = $workout->currency_id;
        }
    }
