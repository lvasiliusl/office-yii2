<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use phpDocumentor\Reflection\Types\Integer;

use common\models\Client;
use common\models\Options;
use common\models\Exercise;
use common\web\BaseController;


/**
 * Site controller
 */
class ClientController extends BaseController
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
                            'index', 'new-client', 'client', 'delete', 'auto-complete',
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
        $model = Client::find();
        $search = Yii::$app->request->get('search');

        if (Yii::$app->request->get('page') == 'new-client') {
            return $this->redirect([ 'client/new-client' ]);
        }

        if (Yii::$app->request->get('client_id') && !Yii::$app->request->get('action')) {
            return $this->redirect([ 'client','id' => Yii::$app->request->get('client_id') ]);
        }

        if( $search ) {

            $search = explode(' ', $search);
            $filter = ['or'];

            foreach( $search as $search_word ) {
               $filter[] = ['like', 'name', $search_word];
               $filter[] = ['like', 'origin', $search_word];
               $filter[] = ['like', 'email', $search_word];
           }

           $model->andFilterWhere( $filter );
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionNewClient()
    {
        $model = new client();

        $postdata = Yii::$app->request->post();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect([ 'client','id' => $model->id ]);
        }

        return $this->render('new-client', [
            'model' => $model
        ]);
    }

    public function actionClient($id)
    {
        $model = Client::findOne(['id' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        }

        return $this->render('single-client', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        if (isset($id)) {
            if (Client::deleteAll(['in', 'id', $id])) {
                $this->redirect(['index']);
            }
        } else {
            $this->redirect(['index']);
        }
    }

    public function actionAutoComplete($query = ''){

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model = Client::find();

        if( $query ) {

            $words = explode(' ', $query);
            $filter = ['or'];

            foreach( $words as $search_word ) {
               $filter[] = ['like', 'name', $search_word];
               $filter[] = ['like', 'origin', $search_word];
               $filter[] = ['like', 'email', $search_word];
           }

           $model->andFilterWhere( $filter );
        }
        return $model->all();
    }
}
