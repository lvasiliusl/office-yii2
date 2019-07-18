<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;

use common\models\User;
use common\models\Client;
use common\models\Project;
use common\web\BaseController;


/**
 * Site controller
 */
class ProjectController extends BaseController
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
                            'index', 'new-project', 'auto-complete',
                            // 'client', 'delete'
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
        $model = Project::find();
        $search = Yii::$app->request->get('search');

        if (Yii::$app->request->get('page') == 'new-project') {
            return $this->redirect([ 'project/new-project' ]);
        }

        if (Yii::$app->request->get('project_id')) {
            return $this->redirect([ 'project','id' => Yii::$app->request->get('project_id') ]);
        }

        if( $search ) {

            $search = explode(' ', $search);
            $filter = ['or'];

            foreach( $search as $search_word ) {
               $filter[] = ['like', 'name', $search_word];
           }

           $model->andFilterWhere( $filter );
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionNewProject()
    {
        $project = new Project();
        $user = User::find();
        $client = Client::find();

        if ($project->load(Yii::$app->request->post()) ) {
            $project->user_id = Yii::$app->user->getId();
            if($project->save()){
                $this->redirect(['index']);
            }
        }

        return $this->render('new-project', [
            'project'   => $project,
            'client'    => $client,
            'user'      => $user,
        ]);
    }


    // public function actionNewProject()
    // {
    //     $project = new Project();
    //     $user = User::find();
    //     $client = Client::find();
    //
    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //
    //         // return $this->redirect([ 'client','id' => $model->id ]);
    //     }
    //
    //     return $this->render('new-project', [
    //         'project'   => $project,
    //         'client'    => $client
    //         'user'      => $user,
    //     ]);
    // }
    //
    // public function actionClient($id)
    // {
    //     $model = Client::findOne(['id' => $id]);
    //     // var_dump(Yii::$app->request->get('action'));die;
    //     if (Yii::$app->request->get('action') == 'delete') {
    //         $model->delete();
    //     }
    //
    //     return $this->render('single-client', [
    //         'model' => $model
    //     ]);
    // }
    //
    // public function actionDelete($id)
    // {
    //     if (isset($id)) {
    //         if (Client::deleteAll(['in', 'id', $id])) {
    //             $this->redirect(['index']);
    //         }
    //     } else {
    //         $this->redirect(['index']);
    //     }
    // }
}
