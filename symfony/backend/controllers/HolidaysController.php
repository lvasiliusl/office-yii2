<?php
namespace backend\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use phpDocumentor\Reflection\Types\Integer;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use common\web\BaseController;

use yii\web\Response;

use common\models\Holidays;

/**
 * Site controller
 */
class HolidaysController extends BaseController
{
    public function behaviors()
    {
       return [
           'access' => [
               'class' => AccessControl::className(),
               'rules' => [
                   [
                       'actions' => [
                           'index',
                           'add',
                           'delete'
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
        $model = Holidays::find();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionAdd()
    {
        if (Yii::$app->user->can('manageHolidays')){
            $model = new Holidays();
            $postData = Yii::$app->request->post();
            if ( $postData ){

                if ($model->load($postData) && $model->save()){
                     return $this->redirect('../holidays');
                }
            }
            return $this->render('add', [
                'model' => $model,
            ]);
        }else{
            $model = Holidays::find();
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete( $id )
    {
        if (Yii::$app->user->can('manageHolidays')){
            $model = new Holidays();
            $holiday = $model->findOne(['id' => $id]);
            $holiday->delete();
            $this->redirect(['holidays/index']);
        }
    }
}
