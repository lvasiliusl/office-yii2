<?php
/* @var $this yii\web\View */
/* @var $model common\models\User */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Profile edit';
?>
<header class="header mobile-only tablet-only">
  <div class="mobile-only tablet-only mobile-menu-current-page"><span><?= strtoupper($this->title); ?></span><i class="header-menu-icon"></i></div>
</header>
<div class="row expanded">
  <div class="column large-12 medium-12 small-12">
    <?php if(Yii::$app->session->hasFlash('message')): ?>
      <div class="client_notification">
        <button class="close_notification"></button>
        <div class="notification_body">
          <p><?= Yii::$app->session->getFlash('message'); ?></p>
        </div>
      </div>
    <?php endif; ?>
    <div class="title-row mobile-no-title"> 
      <div class="title-page float-left">Admin account information</div>
    </div>
    <?php $form = ActiveForm::begin(['id' => 'edit-client-form']); ?>
      <div class="white-block">
        <div class="large-12 block-body">
          <div class="row">
            <div class="large-6 medium-6 small-12 columns">
              <label>First Name
                <?= $form->field($model, 'first_name')->textInput(['autofocus' => true])->label(false) ?>
              </label>
            </div>
            <div class="large-6 medium-6 small-12 columns">
              <label>Last Name
                <?= $form->field($model, 'last_name')->textInput()->label(false) ?>
              </label>
            </div>
            <div class="small-12 columns">
              <label>Email
                <?= $form->field($model, 'email')->input('email')->label(false) ?>
              </label>
            </div>
            <div class="large-6 medium-6 small-12 columns">
              <label>Password
                <?= $form->field($model, 'password')->input('password')->label(false) ?>
              </label>
            </div>
            <div class="large-6 medium-6 small-12 columns">
              <label>Repeat Password
                <?= $form->field($model, 'password_repeat')->input('password')->label(false) ?>
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="float-right">
        <?= Html::submitButton('Save', ['class' => 'button alert btn-large btn-submit']) ?>
      </div>
    <?php ActiveForm::end(); ?>
  </div>
</div>
