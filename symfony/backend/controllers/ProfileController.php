<?php
namespace backend\controllers;

use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use phpDocumentor\Reflection\Types\Integer;
use yii\web\Controller;


use yii\web\Response;
use common\models\User;
use common\models\UserMeta;
use common\models\Options;
use common\models\Exercise;
use common\web\BaseController;
use backend\models\Profile;


/**
 * Site controller
 */
class ProfileController extends BaseController
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
        $model = new Profile();

        $user = $model->findOne(['id' => Yii::$app->user->id]);
        $model->id = $user->id;
        $model->first_name = $user->first_name;
        $model->last_name = $user->last_name;
        $model->email = $user->email;
        $model->card = $user->getMeta('card');

        $postdata = Yii::$app->request->post();
        if (\Yii::$app->request->isAjax && $model->load($postdata)) {
           \Yii::$app->response->format = Response::FORMAT_JSON;
           return \yii\bootstrap\ActiveForm::validate($model);
        }

        if ($model->load($postdata)){
            if ($model->save()){
            }
            return $this->redirect(['/profile']);
        }

        return $this->render('index', [
            'user' => $user,
            'model' => $model
        ]);
    }
}
