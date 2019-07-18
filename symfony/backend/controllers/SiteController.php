<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;


use common\models\User;
use common\models\Options;
use common\web\BaseController;
use common\models\AdminLoginForm;
use common\models\ResetPasswordForm;
use common\models\PasswordResetRequestForm;

use backend\models\AdminProfileForm;

/**
 * Site controller
 */
class SiteController extends BaseController
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
                        'actions' => ['login','request-password-reset','reset-password','error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'settings', 'page-settings'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
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
        $model = new User();
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Displays profile settings page.
     *
     * @return string
     */
    public function actionSettings()
    {
        $model = new AdminProfileForm;
        $model->load( ['AdminProfileForm' => Yii::$app->user->identity->toArray()] );

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->getSession()->setFlash('message', 'Profile has been saved.');
            return $this->redirect(['site/settings']);
        }

        return $this->render('admin-profile', [
            'model' => $model
        ]);
    }

    /**
     * Displays modals settings page.
     *
     * @return string
     */
    public function actionPageSettings()
    {
        $model = new Options;

        $postdata = Yii::$app->request->post();

        if( !empty($postdata) ) {
            foreach ($postdata['Options'] as $option_name => $value) {
                $option = Options::find()->where(['name' => $option_name])->one();

                if( !$option ) {
                    $option = new Options;
                }

                if( is_array($value) ) {
                    $value = serialize($value);
                }

                $option->name = $option_name;
                $option->value = $value;

                $option->save();
            }

            \Yii::$app->getSession()->setFlash('message', 'Settings has been updated.');
            return $this->redirect(['site/page-settings']);
        }

        return $this->render('settings', [
            'model' => $model
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
            $this->bodyClass = ['page-login'];

            if (!Yii::$app->user->isGuest) {
                return $this->goHome();
            }

            $model = new AdminLoginForm();
            if ($model->load(Yii::$app->request->post()) && $model->login()) {
                return $this->goBack();
            } else {
                $this->layout = 'login';

                return $this->render('login', [
                    'model' => $model,
                ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        // return $this->goHome();
        return $this->redirect('/admin/site/login');
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'login';
        $this->bodyClass = ['page-forgot'];
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }
        $this->layout = 'login';
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
