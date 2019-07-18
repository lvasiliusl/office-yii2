<?php
namespace frontend\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use phpDocumentor\Reflection\Types\Integer;
use yii\web\Controller;


use yii\web\Response;
use common\models\User;
use common\models\Project;
use common\models\UserMeta;
use common\models\Options;
use common\models\Exercise;
use common\web\BaseController;
use frontend\models\Profile;
use frontend\models\Salary;
use common\models\Workout;
use yii\helpers\ArrayHelper;


/**
 * Site controller
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
    public function actionIndex()
    {
        $workout = Workout::find()->where(['user_id' => Yii::$app->user->id])->all();
        $workout_data = ArrayHelper::toArray($workout);
        $project = ArrayHelper::map(ArrayHelper::toArray(Project::find()->all()), 'id', 'name');
        $workout_calendar = [];

        foreach($workout_data as $key => $value){
            $year = Yii::$app->formatter->asDate($value['workout_date'], 'Y');
            $month = Yii::$app->formatter->asDate($value['workout_date'] , 'M') - 1;
            $day = Yii::$app->formatter->asDate($value['workout_date'], 'd');
            $workout_calendar[$key] = [$project[$value['project_id']], $year . ', ' . $month . ', ' . $day];
        }

        return $this->render('index', [
            'workout_calendar' => $workout_calendar,
        ]);
    }
}
