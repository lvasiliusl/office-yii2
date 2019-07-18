<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\web\Controller;
use backend\models\PermissionForm;
use common\models\Options;
use yii\web\NotFoundHttpException;
use yii\bootstrap\ActiveForm;


class PermissionFormController extends Controller {

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

    public function actionIndex()
    {
            $postdata=Yii::$app->request->post('PermissionForm') ?? [];
            if($postdata) {
                PermissionForm::newPermission( $postdata['name'] );
                foreach ( $postdata['roles'] as $role=>$status ) {
                    if( $status==='1' ){
                        PermissionForm::addAssigment( $role, $postdata['name'] );
                    }
                }
                return $this->redirect(['rbac/index']);
            }
            $model = new PermissionForm;

            return $this->render('index', [
                'model' => $model,
            ]);
        }
}
