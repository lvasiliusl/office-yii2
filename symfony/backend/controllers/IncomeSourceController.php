<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\web\BaseController;
use common\models\Currency;
use common\models\IncomeSource;

/**
 * Income Source Controller
 */
class IncomeSourceController extends BaseController
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
                            'income-source',
                            'new-income-source',
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
        $source = IncomeSource::find();

        return $this->render('/finance/income-source', ['source' => $source]);
    }

    /**
     * @inheritdoc
     */
    public function actionNewIncomeSource()
    {
        $model = new IncomeSource;
        $balanceCurrency = Currency::find()->indexBy('id')->all();
        $arrCurrencys = [];

        foreach ($balanceCurrency as $value) {
            $arrCurrencys[$value->id] = $value->code;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('../income-source');
        }

        return $this->render('/finance/new-income-source',
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
        $model = IncomeSource::findOne($id);
        $model->delete();

        return $this->redirect('../income-source');
    }
}
