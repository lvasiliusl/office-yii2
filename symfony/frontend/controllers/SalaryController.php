<?php
namespace frontend\controllers;

use Yii;
use DateTime;

use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use phpDocumentor\Reflection\Types\Integer;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use yii\web\Response;
use common\web\BaseController;
use common\models\Salary;

use common\models\Project;
use common\models\Workout;
use common\models\UserBalance;
use common\models\WorkoutTransactions;
use common\helpers\TimeHelper;

/**
 * Site controller
 */
class SalaryController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
/**
 * Displays homepage.
 *
 * @return string
 */
    public function actionIndex($month = Null, $side_month = Null, $year = Null)
    {
        $model = new Salary;
        $view_date = new DateTime(date('d-m-Y'));

        if($month!=Null && $side_month != Null && $year != Null){
            $month_number = array_flip($model::getMonth())[$month];
            $view_date = new DateTime(date('d-m-Y', mktime(0, 0, 0, $month_number, 1, $year)));
            $qwe = $view_date->format('m');

            if($side_month == '+1'){
                $view_date->modify('+1 month');
                $year = $view_date->format('Y');
                $prev_month_name = Salary::getMonth()[$qwe == 1 ? 12 : $qwe - 1];
                $next_month_name = Salary::getMonth()[$qwe == 12 ? 1 : $qwe + 1];

                if ($model::getCurrentMonth() == $qwe){
                    $next_month_name = Null;
                }
            }

            if($side_month == '-1'){
                $view_date->modify('-1 month');
                $year = $view_date->format('Y');
                $prev_month_name = Salary::getMonth()[$qwe == 1 ? 12 : $qwe - 1];
                $next_month_name = Salary::getMonth()[$qwe == 12 ? 1 : $qwe + 1];
            }

        }else{
            $month_number = $model::getCurrentMonth();
            $prev_month_name = $model::getMonth()[$model::getCurrentMonth() - 1];
            $year = $model::getCurrentYear();
            $next_month_name = Null;
        }
        $month_days = $model::getWeekDays($year, $month_number);
        $hourly_month = $model::getHourlyMonth(
            $model::getMonthvsHollidays($month_number),
            $model::getDaysAmount($month_number, $year),
            $month_number,
            $year
        );

        $workout = Workout::find();
        $workout->andFilterWhere(['user_id' => Yii::$app->user->id]);
        $workoutid = ArrayHelper::toArray(Workout::findAll(['user_id' => Yii::$app->user->id]),['id']);
        $monthmax = count($model::getMonthMax($model::getWeekDays($year, $month_number))) * 6;

        if ( empty($workoutid) == TRUE ){

            $workoutdata = 0;

        }else {
            foreach ($workoutid as $key => $value) {
                $workoutdata[] = $value['id'];
            }
        }

        $transaction = WorkoutTransactions::find();
        $transaction->andFilterWhere(['workout_id' => $workoutdata]);
        $userbalance = UserBalance::findOne(['user_id' => Yii::$app->user->id]);
        $hour = TimeHelper::timeHelper($workoutid);
        $percent = $hour['1']/$monthmax*100;
        $overwork = [];

        if ($hourly_month != Null){
            foreach ($hourly_month as $key => $value){
                if($value > 360){
                    $overwork[$key] = $value - 360 ;
                }else{
                    $overwork[$key] = 0;
                }
            }
        }else{
            foreach ($month_days as $key => $value) {
                $overwork[$key] = 0;
                $hourly_month[$key] = 0;
            }
        }

        return $this->render('index', [
            'model'         => $model,
            'transaction'   => $transaction,
            'workout'       => $workout,
            'userbalance'   => $userbalance,
            'hour'          => $hour['0'],
            'percent'       => $percent,
            'monthmax'      => $monthmax,
            'hourly_month'  => $hourly_month,
            'month_days'    => $month_days,
            'prev_month'    => $prev_month_name,
            'next_month'    => $next_month_name,
            'year'          => $year,
            'overwork'      => $overwork,
        ]);
    }
}
