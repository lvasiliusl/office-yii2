<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-md-3 center">
        <div class="login-box">
            <a href="index.html" class="logo-name text-lg text-center">Modern</a>
            <p class="text-center m-t-md">Enter your e-mail address below to reset your password</p>
                <?php $form = ActiveForm::begin(['options' => ['class' => 'm-t-md']]); ?>
                <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>

                <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block']) ?>
                <?= Html::a('Back', ['site/login'], ['class' => 'btn btn-default btn-block m-t-md']) ?>
            <?php ActiveForm::end(); ?>
            <p class="text-center m-t-xs text-sm"><?= date('Y'); ?> &copy; Webbee.pro</p>
        </div>
    </div>
</div><!-- Row -->
