<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\web\BaseController;
use common\models\Currency;
use common\models\CurrencyExchange;

/**
 * Currency Exchange Controller
 */
class CurrencyExchangeController extends BaseController
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
                            'currency-exchange',
                            'new-currency-exchange',
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
        $exchange = CurrencyExchange::find();

        return $this->render('/finance/currency-exchange', ['exchange' => $exchange]);
    }

    /**
     * @inheritdoc
     */
    public function actionNewCurrencyExchange()
    {
        $model = new CurrencyExchange;
        $balanceCurrency = Currency::find()->indexBy('id')->all();
        $arrCurrencys =[];

        foreach ($balanceCurrency as $value) {
            $arrCurrencys[$value->id] = $value->code;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('../currency-exchange');
        }

        return $this->render('/finance/new-currency-exchange',
        [
            'model' => $model,
            'arrCurrencys' => $arrCurrencys
        ]);
    }

    /**
     *{@inheritdoc}
     */
    public function actionDelete($id)
    {
        $model = CurrencyExchange::findOne($id);
        $model->delete();

        return $this->redirect('../currency-exchange');
    }
}
