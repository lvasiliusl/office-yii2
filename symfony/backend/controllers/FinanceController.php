<?php
namespace backend\controllers;

use common\models\Currency;
use common\models\OfficeBalance;
use yii\filters\AccessControl;
use common\web\BaseController;

/**
 * Finance Controller
 */
class FinanceController extends BaseController
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
        $model = OfficeBalance::find();

        return $this->render('index', ['model' => $model]);
    }
}
