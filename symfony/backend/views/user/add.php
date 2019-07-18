<?php
/* @var $this yii\web\View */
/* @var $model common\models\User */

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\base\UserException;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use common\helpers\Role;


use backend\assets\AppAsset;

$this->title = $model->id ? 'Edit User' : 'New User';?>
<?php Pjax::begin(['id' => 'new_user']); ?>
<div class="page-title">
    <h3><?= $this->title ?></h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li>
                <a href="<?= yii\helpers\Url::to(['user/']); ?>">Users</a>
            </li>
            <li class="active"><?= $this->title ?></li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper">
                            <?php if (empty($arrCurrencys)): ?>
                                <div class="alert alert-warning">
                                    <strong>Warning!</strong> Add currency first.
                                    <a href="<?= Url::to(['/currency/new-currency']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Currency</a>
                                    <div class="clearfix"></div>
                                </div>
                            <?php endif; ?>
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
                            <?php if (Yii::$app->user->can('changeSalary')): ?>
                                <div class="form-group">
                                    <label for="inputSalary">Salary</label>
                                    <?=
                                        $form->field($model, 'salary_type')->dropDownList(['fixed' => 'Fixed', 'hourly' => 'Hourly'])->label(false),
                                        $form->field($model, 'salary')->textInput(['class' => 'form-control'])->label(false),
                                        $form->field($model, 'currency_id')->dropDownList($arrCurrencys)->label(false)
                                    ?>
                                </div>
                            <?php endif?>
                            <?= $form->field($model, 'role')->dropDownList(Role::getAllowedRoles(true))->label(false) ?>
                            <div class="row">
                                <?php if ($model->id): ?>
                                    <div class='col-sm-6'>
                                        <a href="<?= Url::to(['user/delete', 'id' => $model->id])?>" class = 'btn btn-danger')>Delete</a>
                                    </div>
                                <?php endif?>
                                <div class='col-sm-6 text-right'>
                                    <?= Html::submitButton( 'Save', ['class' => 'btn btn-success']) ?>
                                </div>

                            </div>
                        <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
