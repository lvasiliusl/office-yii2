<?php
namespace backend\controllers;
use Yii;
use DateTime;

use yii\filters\AccessControl;
use common\web\BaseController;

use common\models\User;
use common\models\Project;
use common\models\Workout;
use common\models\Currency;
use common\models\OfficeBalance;
use common\models\WorkoutUpdate;
use common\models\WorkoutTransactions;
use common\models\CurrencyExchange;
use yii\helpers\ArrayHelper;
use common\models\Salary;
use common\models\UserBalance;
use common\helpers\TimeHelper;

/**
 * Balance Controller
 */
class WorkoutController extends BaseController
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
                            'index',
                            'workout',
                            'new-workout',
                            'user-workout',
                            'update'
                        ],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $search = Yii::$app->request->get('s');

        $workouts = Workout::find();

        if( $search ) {
            $workoutUser =  User::find()->indexBy('id')->all();
            $workoutProject = Project::find()->indexBy('id')->all();
            $searchWord = strtolower($search);

            foreach ($workoutUser as $value) {
                $arrUsers[$value->id] = strtolower($value->first_name) . ' ' . strtolower($value->last_name);
            }

            foreach ($workoutProject as $value) {
                $arrProjects[$value->id] = strtolower($value->name);
            }

            if (array_key_exists($searchWord, $user) == true ){
                $workouts->andFilterWhere(['user_id' => array_flip($arrUsers)[$searchWord]]);
            }elseif (array_key_exists($searchWord, $project) == true ) {
                $workouts->andFilterWhere(['project_id' => array_flip($arrProjects)[$searchWord]]);
            }
        }

        $this->view->title = 'Workout';
        return $this->render('/finance/workout',
        [
            'workouts' => $workouts
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionNewWorkout()
    {

        $model = new Workout;
        $workoutCurrency = Currency::find()->indexBy('id')->all();
        $workoutUser =  User::find()->indexBy('id')->all();
        $workoutProject = Project::find()->indexBy('id')->all();
        $postData = Yii::$app->request->post();
        $modelData = [];
        $arrUsers = ['' => '-'];
        $arrProjects = ['' => '-'];
        $arrCurrencys = ['' => '-'];
        $usersSalary = [];

        foreach ($workoutUser as $value) {
            $arrUsers[$value->id] = ucfirst($value->first_name).' '.ucfirst($value->last_name);
        }

        foreach ($workoutProject as $value) {
            $arrProjects[$value->id] = ucfirst($value->name);
        }

        foreach ($workoutCurrency as $value) {
            $arrCurrencys[$value->id] = $value->code;
        }

        foreach ($workoutUser as $value) {
            $usersSalary[$value->id] = [
                'salary' => $value->salary,
                'salary_type' => $value->salary_type,
                'currency_id' => $value->currency_id,
            ];
        }


        if ( $postData ) {
            $modelData['Workout']['user_id']        = $postData['Workout']['user_id'];
            $modelData['Workout']['project_id']     = $postData['Workout']['project_id'];
            $modelData['Workout']['rate_type']      = $postData['Workout']['rate_type'];
            $modelData['Workout']['fixed']          = $postData['Workout']['fixed'];
            $modelData['Workout']['rate']           = $postData['Workout']['rate'];
            $modelData['Workout']['description']    = $postData['Workout']['description'];

            if ($postData['Workout']['hours_h']) {
                if ($postData['Workout']['hours_m']) {
                    $modelData['Workout']['hours'] = Yii::$app->formatter->asTime($postData['Workout']['hours_h'].':'.$postData['Workout']['hours_m'].':'. 00, 'hh:mm:ss');
                } else {
                    $modelData['Workout']['hours'] = Yii::$app->formatter->asTime($postData['Workout']['hours_h'].':'. 00 .':'. 00, 'hh:mm:ss');
                }
            } else {
                $modelData['Workout']['hours'] = '';
            }
            $modelData['Workout']['workout_date'] = Yii::$app->formatter->asTimestamp($postData['Workout']['workout_date']);

            if ($modelData['Workout']['workout_date'] == 0 || $modelData['Workout']['workout_date'] == '' || $modelData['Workout']['workout_date'] >= time()){
                $modelData['Workout']['workout_date'] = time();
            }

            $modelData['Workout']['currency_id'] = $postData['Workout']['currency_id'];
            if ($model->load($modelData) && $model->save(false)) {
                $modelq = OfficeBalance::find()->where(['name' => 'Salary Balance'])->one();

                if ( $modelData['Workout']['currency_id'] == 1 ){
                    $modelq->money_amount = OfficeBalance::findOne(['name' => 'Salary_balance'])['money_amount'] - WorkoutTransactions::findOne(['workout_id' => $model->id])['summ'];
                }elseif( $modelData['Workout']['currency_id'] == 2 ){
                    $exchange = CurrencyExchange::find()->orderBy('id DESC')->one();
                    $modelq->money_amount = OfficeBalance::findOne(['name' => 'Salary Balance'])['money_amount'] - ( WorkoutTransactions::findOne(['workout_id' => $model->id])['summ'] * $exchange['rate'] );
                }
                $modelq->save();
                return $this->redirect('../workout');
            }
        }
        // var_dump($usersSalary);die;

        $this->view->title = 'New Workout';

        return $this->render('/finance/new-workout',
        [
            'model'        => $model,
            'arrCurrencys' => $arrCurrencys,
            'arrUsers'     => $arrUsers,
            'arrProjects'  => $arrProjects,
            'usersSalary' => $usersSalary
        ]);
    }

    public function actionUpdate($id){

        $postData = Yii::$app->request->post();
        $workout = new WorkoutUpdate(['id' => $id]);

        $workoutUser =  User::find()->indexBy('id')->all();
        $workoutCurrency = Currency::find()->indexBy('id')->all();
        $workoutProject = Project::find()->indexBy('id')->all();

        foreach ($workoutUser as $value) {
            $arrUsers[$value->id] = ucfirst($value->first_name).' '.ucfirst($value->last_name);
        }

        foreach ($workoutProject as $value) {
            $arrProjects[$value->id] = ucfirst($value->name);
        }

        foreach ($workoutCurrency as $value) {
            $arrCurrencys[$value->id] = $value->code;
        }

        $workout->workout_date = Yii::$app->formatter->asDate($workout->workout_date, 'dd-MM-yyyy');

        if ($postData){
            $model = Workout::findOne(['id'=> $id]);
            $modelData['Workout']['user_id']        = $postData['WorkoutUpdate']['user_id'];
            $modelData['Workout']['project_id']     = $postData['WorkoutUpdate']['project_id'];
            $modelData['Workout']['rate_type']      = $postData['WorkoutUpdate']['rate_type'];
            $modelData['Workout']['fixed']          = $postData['WorkoutUpdate']['fixed'];
            $modelData['Workout']['rate']           = $postData['WorkoutUpdate']['rate'];
            $modelData['Workout']['description']    = $postData['WorkoutUpdate']['description'];

            if ($postData['WorkoutUpdate']['hours_h']) {
                if ($postData['WorkoutUpdate']['hours_m']) {
                    $modelData['Workout']['hours'] = Yii::$app->formatter->asTime($postData['WorkoutUpdate']['hours_h'].':'.$postData['WorkoutUpdate']['hours_m'].':'. 00, 'hh:mm:ss');
                } else {
                    $modelData['Workout']['hours'] = Yii::$app->formatter->asTime($postData['WorkoutUpdate']['hours_h'].':'. 00 .':'. 00, 'hh:mm:ss');
                }
            } else {
                $modelData['Workout']['hours'] = '';
            }
            $modelData['Workout']['workout_date'] = Yii::$app->formatter->asTimestamp($postData['WorkoutUpdate']['workout_date']);

            if ($modelData['Workout']['workout_date'] == 0 || $modelData['Workout']['workout_date'] == '' || $modelData['Workout']['workout_date'] >= time()){
                $modelData['Workout']['workout_date'] = time();
            }

            $modelData['Workout']['currency_id'] = $postData['WorkoutUpdate']['currency_id'];
            // var_dump($modelData);die;

            if ($model->load($modelData) && $model->save()) {
                $modelq = OfficeBalance::find()->where(['name' => 'Salary Balance'])->one();

                if ( $modelData['Workout']['currency_id'] == 1 ){
                    $modelq->money_amount = OfficeBalance::findOne(['name' => 'Salary_balance'])['money_amount'] - WorkoutTransactions::findOne(['workout_id' => $model->id])['summ'];
                }elseif( $modelData['Workout']['currency_id'] == 2 ){
                    $exchange = CurrencyExchange::find()->orderBy('id DESC')->one();
                    $modelq->money_amount = OfficeBalance::findOne(['name' => 'Salary Balance'])['money_amount'] - ( WorkoutTransactions::findOne(['workout_id' => $model->id])['summ'] * $exchange['rate'] );
                }
                $modelq->save();
                return $this->redirect('../workout');
        }}
        return $this->render('/finance/workout-update',
        [
            'model'        => $workout,
            'arrCurrencys' => $arrCurrencys,
            'arrUsers'     => $arrUsers,
            'arrProjects'  => $arrProjects
        ]);
    }


    public function actionUserWorkout($month = Null, $side_month = Null, $year = Null, $id)
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
            $year,
            $id
        );

        $workout = Workout::find();
        $workout->andFilterWhere(['user_id' => $id]);
        $workoutid = ArrayHelper::toArray(Workout::findAll(['user_id' => $id]),['id']);
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
        $userbalance = UserBalance::findOne(['user_id' => $id]);
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

        return $this->render('/finance/user-workout', [
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
