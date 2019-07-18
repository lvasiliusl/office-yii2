<?php
namespace backend\controllers;

use Yii;
use common\models\Currency;
use common\models\UserBalance;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use phpDocumentor\Reflection\Types\Integer;
use yii\web\Controller;


use yii\web\Response;
use backend\models\UserForm;
use common\models\User;
use common\models\Options;
use common\models\Exercise;
use common\web\BaseController;
use yii\bootstrap\ActiveForm;


/**
 * Site controller
 */
class UserController extends BaseController
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
                            'index', 'add', 'edit', 'delete'
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $current_user = Yii::$app->user;

        $query = User::find()->where(['!=', 'id', $current_user->id]);
        $search = Yii::$app->request->get('s');
        $filter = Yii::$app->request->get('role');

        if( $search ) {
            $search = explode(' ', $search); 
            $filter = ['or'];

            foreach( $search as $search_word ) {
                $filter[] = ['like', 'first_name', $search_word];
                $filter[] = ['like', 'last_name', $search_word];
                $filter[] = ['like', 'email', $search_word];
            }

            $query->andFilterWhere( $filter );
        }

        if ( $filter ) {
            $usersId = Yii::$app->authManager->getUserIdsByRole($filter);
            $query->andFilterWhere(['id' => $usersId]);
        }

        return $this->render('index', [
            'query' => $query,
        ]);
    }

    public function actionAdd()
    {
        $model = new UserForm();
        $userBalanceModel = new UserBalance;
        $balanceCurrency = Currency::find()->indexBy('id')->all();
        $arrCurrencys = [];
        $userBalanceData = [];
        $newUserId = '';
        $postdata = Yii::$app->request->post();

        foreach ($balanceCurrency as $value) {
            $arrCurrencys[$value->id] = $value->code;
        }


        if (Yii::$app->request->isAjax && $model->load($postdata)) {
           Yii::$app->response->format = Response::FORMAT_JSON;
           return ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post()) && $model->save()){
            $newUserId = User::find()->indexBy('id')->where(['email' => $model->email])->one();
            $userBalanceData = [
                'user'      => $newUserId->id,
                'currency_id'  => $model->currency_id,
            ];
            if ($userBalanceModel->load($userBalanceData) && $userBalanceModel->save()) {
                return $this->redirect('../user');
            }
        }

        return $this->render('add', [
            'model' => $model,
            'arrCurrencys' => $arrCurrencys
        ]);
    }

    public function actionEdit( $id )
    {
        $model = new UserForm();
        $user = $model->findOne(['id' => $id]);
        $balanceCurrency = Currency::find()->indexBy('id')->all();
        $arrCurrencys = [];

        foreach ($balanceCurrency as $value) {
            $arrCurrencys[$value->id] = $value->code;
        }

        $model->id = $user->id;
        $model->first_name = $user->first_name;
        $model->last_name = $user->last_name;
        $model->email = $user->email;
        $model->salary_type = $user->salary_type;
        $model->currency_id = $user->currency_id;
        $model->salary = $user->salary;

        $postdata = Yii::$app->request->post();
        if (\Yii::$app->request->isAjax && $model->load($postdata)) {
           \Yii::$app->response->format = Response::FORMAT_JSON;
           return ActiveForm::validate($model);
        }

        if ($model->load($postdata) && $model->save()){
        }

        return $this->render('add', [
            'model' => $model,
            'user' => $user,
            'arrCurrencys' => $arrCurrencys,
        ]);
    }

    public function actionDelete( $id )
    {
        $model = new UserForm();
        $current_user = Yii::$app->user;
        if (Yii::$app->user->can('manage' . ucfirst(key(Yii::$app->authManager->getRolesByUser($id))))){
            if (User::find()->where(['!=', 'id', $current_user->id]) !== $id){
                $user = $model->findOne(['id' => $id]);
                $user->delete();
            }
        $this->redirect(['user/index']);
        }
    }

    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency']);
    }
}
