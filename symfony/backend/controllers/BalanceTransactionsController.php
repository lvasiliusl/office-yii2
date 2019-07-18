<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\models\OfficeBalance;
use common\web\BaseController;
use common\models\BalanceTransactions;
use common\models\BalanceTransactionsTemp;
use yii\helpers\ArrayHelper;

/**
 *
 */
 class BalanceTransactionsController extends BaseController
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
                            'balance-transactions',
                            'new-balance-transactions',
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
        $model = BalanceTransactions::find();

        return $this->render('/finance/balance-transactions', ['model' => $model]);
    }

    /**
     * @inheritdoc
     */
    public function actionNewBalanceTransactions()
    {
        $model = new BalanceTransactionsTemp;
        $arrBalances = [];


        $transactionBalance = OfficeBalance::find()->indexBy('id')->all();
        foreach ($transactionBalance as $value) {
            $arrBalances[$value->id] = $value->name;
        }

        $formFieldsData = Yii::$app->request->post();
        if ($formFieldsData) {
            $data = ArrayHelper::getValue($formFieldsData, 'BalanceTransactionsTemp');
            // var_dump($data);die;
            if ($model->load($data) && $model->save()) {
                return $this->redirect('../balance-transactions');
            }
        }


        return $this->render('/finance/new-balance-transactions', ['model' => $model, 'arrBalances' => $arrBalances]);
    }

    /**
     * {@inheritdoc}
     */
    public function actionDelete($id)
    {
        $model =  new BalanceTransactionsTemp;
        $transaction = BalanceTransactions::findOne($id);
        $balance_from = OfficeBalance::findOne(['id' => $transaction->balance]);
        $balance_to = OfficeBalance::findOne(['name' => explode(' ', $transaction->title)]);
        $transactions_to_from = BalanceTransactions::findAll(['created_at' => $transaction->created_at]);
        $transactions = array_keys(ArrayHelper::map($transactions_to_from, 'id', 'summ'));

        if($transactions['0'] != $id){
            $transaction_second_id = $transactions['0'];
        }else{
            $transaction_second_id = $transactions['1'];
        }

        $transaction_second = BalanceTransactions::findOne($transaction_second_id);

        $data = [
            'from_balance'  => $balance_to->id,
            'from_summ'     => $transaction_second->summ,
            'to_balance'    => $balance_from->id,
            'to_summ'       => $transaction->summ,
            'description'   => 'Transaction ' . $id . ' cancel'
        ];
        if ($model->load($data) && $model->save()) {
            return $this->redirect('../balance-transactions');
        }
    }
}
