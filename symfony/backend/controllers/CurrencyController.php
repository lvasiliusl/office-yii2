<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\web\BaseController;
use common\models\Currency;



/**
 * Currency Controller
 */
class CurrencyController extends BaseController
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
                            'currency',
                            'new-currency',
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
        $model = Currency::find();

        return $this->render('/finance/currency', ['model' => $model]);
    }

    /**
     * @inheritdoc
     */
    public function actionNewCurrency()
    {
        $model = new Currency;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect('../currency');
            }

        return $this->render('/finance/new-currency', ['model' => $model]);
    }

    /**
     * {@inheritdoc}
     */
    public function actionDelete($id)
    {
        $model = Currency::findOne($id);
        $model->delete();

        return $this->redirect('../currency');
    }
}
