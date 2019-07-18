<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-3 center">
        <div class="login-box">
            <a href="index.html" class="logo-name text-lg text-center">Modern</a>
            <p class="text-center m-t-md">Please login into your account.</p>
            <?php $form = ActiveForm::begin(['options' => ['class' => 'm-t-md']]); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
                <?= Html::submitButton('Login', ['class' => 'btn btn-success btn-block']) ?>
                <?= Html::a('Forgot Password?', ['site/request-password-reset'], ['class' => 'display-block text-center m-t-md text-sm']) ?>
            <?php ActiveForm::end(); ?>
            <p class="text-center m-t-xs text-sm"><?= date('Y'); ?> &copy; Webbee.pro</p>
        </div>
    </div>
</div><!-- Row -->
