<?php
/* @var $this yii\web\View */
/* @var $model common\models\Profile */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\base\UserException;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

use backend\assets\AppAsset;

$this->title = 'Profile'?>
<?php Pjax::begin(['id' => 'profile']); ?>
<div class="page-title">
    <h3>Profile</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-3 user-profile client-profile">
            <h3 class="text-center"><?= $user->first_name . ' ' . $user->last_name?></h3>
            <p class="text-center"><?= $user->salary_type?></p>
            <p class="text-center"><?= $user->salary . ' ' .  $user->currency->code?></p>
            <ul class="list-unstyled text-center">
                <li><p><i class="fa fa-envelope m-r-xs"></i><a href="mailto:<?= $model->email?>"><?= $model->email?></a></p></li>
            </ul>
            <hr>
        </div>
        <div class="col-md-6 m-t-lg">
            <h2 class='non-margin-top'>Edit Profile</h2>
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="post">
                        <?php $form = ActiveForm::begin([
                            'options' => [
                                'class' => 'col-md-8 col-md-offset-2',
                                'autocomplete' => 'off'
                             ]
                        ]); $form->enableAjaxValidation = true; ?>
                        <div class="form-group">
                            <label for="inputFirstName">First name</label>
                            <?= $form->field($model, 'first_name')->textInput(['class' => 'form-control'])->label(false) ?>
                        </div>
                        <div class="form-group">
                            <label for="inputLastName">Last name</label>
                            <?= $form->field($model, 'last_name')->textInput(['class' => 'form-control'])->label(false) ?>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <?= $form->field($model, 'email')->input('email',['class' => 'form-control'])->label(false)?>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                                <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control'])->label(false) ?>
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordRepeat">Confirm Password</label>
                                <?= $form->field($model, 'password_repeat')->passwordInput(['class' => 'form-control'])->label(false) ?>
                        </div>
                        <div class="form-group">
                            <label for="inputCard">Card</label>
                            <?= Html::textInput('User[meta][card]', $model->card, ['class' => 'form-control']); ?>
                        </div>
                        <div class="row">
                            <div class='col-sm-6 text-right'>
                                <?= Html::submitButton('<i class="fa fa-save m-r-xs"></i> Save', ['class' => 'btn btn-success pull-right']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
