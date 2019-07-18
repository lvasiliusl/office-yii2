<?php
namespace backend\controllers;

use common\web\BaseController;
use yii\filters\AccessControl;

use common\models\FinanceReports;
/**
 *
 */
class ReportsController extends BaseController
{
    /**
    * @inheritdoc
    */
    public function behaviors()
    {
        return [
            'access' => [
                'class' =>  AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
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
        $qwe = new FinanceReports;
        $model = $qwe->officeBalancesReports();

        // var_dump($model);die;
        $this->view->title = $model;
        return $this->render('index', ['model' => $model]);
    }
}
