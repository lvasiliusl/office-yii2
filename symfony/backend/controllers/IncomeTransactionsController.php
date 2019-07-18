<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\web\BaseController;
use common\models\Currency;
use common\models\OfficeBalance;
use common\models\IncomeSource;
use common\models\IncomeTransactions;

/**
 * Income Transactions Controller
 */
class IncomeTransactionsController extends BaseController
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
                            'income-transactions',
                            'new-income-transactions',
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
        $incomeTransactions = IncomeTransactions::find();

        return $this->render('/finance/income-transactions',
        [
            'incomeTransactions' => $incomeTransactions
        ]);
    }

    /**
    * @inheritdoc
    */
    public function actionNewIncomeTransactions()
    {
        $model = new IncomeTransactions;
        $arrCurrencys = [];
        $arrSources = [];
        $arrBalances = [];

        $transactionCurrency = Currency::find()->indexBy('id')->all();
        foreach ($transactionCurrency as $value) {
            $arrCurrencys[$value->id] = $value->code;
        }

        $transactionSource = IncomeSource::find()->indexBy('id')->all();
        foreach ($transactionSource as $value) {
            $arrSources[$value->id] = $value->name;
        }

        $transactionBalance = OfficeBalance::find()->indexBy('id')->all();
        foreach ($transactionBalance as $value) {
            $arrBalances[$value->id] = $value->name;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('../income-transactions');
        }

        return $this->render('/finance/new-income-transactions',
        [
            'model' => $model,
            'arrCurrencys' => $arrCurrencys,
            'arrSources'   => $arrSources,
            'arrBalances'  => $arrBalances,
        ]);
    }

    /**
    * {@inheritdoc}
    *
    *@param int $id
    */
    public function actionDelete($id)
    {
        $model = IncomeTransactions::findOne($id);
        $model->delete();

        return $this->redirect('../income-transactions');
    }
}
