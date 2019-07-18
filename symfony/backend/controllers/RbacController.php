<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\data\Pagination;
use yii\web\Controller;
use backend\models\Rbac;
use common\models\Options;
use yii\web\NotFoundHttpException;

class RbacController extends Controller {

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
                            'index','delete'
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
    public function action()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $postdata = Yii::$app->request->post('Role') ?? [];
        if( $postdata ) {
            foreach ($postdata as $rolename => $permissions) {
                foreach ($permissions as $permission => $status) {
                    if ( $status==='0' ){
                        Rbac::removeAssigment($rolename,$permission);
                    }
                    elseif ( $status==='1' ){
                        Rbac::addAssigment($rolename, $permission);
                    }
                }
            }
            return $this->redirect(['rbac/index']);
        }

        $model = new Rbac;

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionDelete($delete){
            $auth = Yii::$app->authManager;
            $permission=$auth->getPermission($delete);
            $auth->remove($permission);
            return $this->redirect(['rbac/index']);
    }
}
