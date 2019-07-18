<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\web\BaseController;
use common\models\Currency;
use common\models\OfficeBalance;

/**
 * Balance Controller
 */
class BalanceController extends BaseController
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
                            'balance',
                            'new-balance',
                            'edit',
                            'delete',
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
        $balances = OfficeBalance::find();

        return $this->render('/finance/balance', ['balances' => $balances]);
    }

    /**
     * @inheritdoc
     */
    public function actionNewBalance()
    {
        $model = new OfficeBalance;
        $balanceCurrency = Currency::find()->indexBy('id')->all();
        $arrCurrencys = [];

        foreach ($balanceCurrency as $value) {
            $arrCurrencys[$value->id] = $value->code;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('../balance');
        }

        $this->view->title = 'New Balance';

        return $this->render('/finance/new-balance',
        [
            'model' => $model,
            'arrCurrencys' => $arrCurrencys
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function actionEdit($id)
    {
        $model = OfficeBalance::findOne($id);
        $balanceCurrency = Currency::find()->indexBy('id')->all();
        $arrCurrencys = [];

        foreach ($balanceCurrency as $value) {
            $arrCurrencys[$value->id] = $value->code;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('finance');
        }

        $this->view->title = 'Edit Balance';

        return $this->render('/finance/new-balance',
        [
            'model' => $model,
            'arrCurrencys' => $arrCurrencys
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function actionDelete($id)
    {
        $model = OfficeBalance::findOne($id);
        $model->delete();

        return $this->redirect('../balance');
    }
}
