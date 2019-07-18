<?php
/* @var $this yii\web\View */
/* @var $model common\models\Options */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use pendalf89\filemanager\widgets\TinyMce;

$this->title = 'Settings';
?>
<header class="header">
  <div class="mobile-only tablet-only mobile-menu-current-page"><span>SETTINGS</span><i class="header-menu-icon"></i></div>
</header>
<?php $form = ActiveForm::begin(['id' => 'site-settings-form']); ?>
<div class="row expanded">
    <div class="column small-12">
        <?php if(Yii::$app->session->hasFlash('message')): ?>
            <div class="client_notification">
                <button class="close_notification"></button>
                <div class="notification_body">
                    <p><?= Yii::$app->session->getFlash('message'); ?></p>
                </div>
            </div>
        <?php endif; ?>
        <div class="title-row mobile-no-title"> 
          <div class="title-page float-left">MODALS</div>
        </div>
    </div>
    <div class="column large-12 medium-12 small-12">
        <div class="white-block">
            <ul class="accordion" data-accordion>
                <li class="accordion-item is-active" data-accordion-item>
                    <?php 
                    $option = $model->getOption('bio-account-body-fat');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#bio-account-body-fat" class="accordion-title">
                        Biometrics - Body Fat
                    </a>
                    <div class="accordion-content" data-tab-content id="bio-account-body-fat">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[bio-account-body-fat][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= TinyMce::widget([
                                        'name' => 'Options[bio-account-body-fat][content]',
                                        'value' => $content,
                                        'clientOptions' => [
                                               'language' => 'en',
                                            'menubar' => false,
                                            'height' => 500,
                                            'image_dimensions' => false,
                                            'plugins' => [
                                                'advlist autolink lists link image charmap print preview anchor searchreplace visualblocks code contextmenu table',
                                            ],
                                            'toolbar' => 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | code',
                                        ],
                                    ]); ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="accordion-item" data-accordion-item>
                    <?php 
                    $option = $model->getOption('bio-lean-bodymass');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#bio-lean-bodymass" class="accordion-title">
                        Biometrics - Lean Bodymass
                    </a>
                    <div class="accordion-content" data-tab-content id="bio-lean-bodymass">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[bio-lean-bodymass][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[bio-lean-bodymass][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="accordion-item" data-accordion-item>
                    <?php 
                    $option = $model->getOption('bio-blood-presure');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#bio-blood-presure" class="accordion-title">
                        Biometrics - Blood Presure Systolic/Diastolic
                    </a>
                    <div class="accordion-content" data-tab-content id="bio-blood-presure">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[bio-blood-presure][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[bio-blood-presure][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="accordion-item" data-accordion-item>
                    <?php 
                    $option = $model->getOption('bio-resting-heart-rate');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#bio-resting-heart-rate" class="accordion-title">
                        Biometrics - Resting Heart Rate
                    </a>
                    <div class="accordion-content" data-tab-content id="bio-resting-heart-rate">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[bio-resting-heart-rate][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[bio-resting-heart-rate][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="white-block">
            <ul class="accordion" data-accordion>
                <li class="accordion-item is-active" data-accordion-item>
                    <?php 
                    $option = $model->getOption('nutrition-activity-lvl');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#nutrition-activity-lvl" class="accordion-title">
                        Nutrition - Activity Level
                    </a>
                    <div class="accordion-content" data-tab-content id="nutrition-activity-lvl">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[nutrition-activity-lvl][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[nutrition-activity-lvl][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="white-block">
            <ul class="accordion" data-accordion>
                <li class="accordion-item is-active" data-accordion-item>
                    <?php 
                    $option = $model->getOption('cardio-anaerobic-heart-rate');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#cardio-anaerobic-heart-rate" class="accordion-title">
                        Cardio - Anaerobic Heart Rate
                    </a>
                    <div class="accordion-content" data-tab-content id="cardio-anaerobic-heart-rate">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[cardio-anaerobic-heart-rate][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[cardio-anaerobic-heart-rate][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="accordion-item" data-accordion-item>
                    <?php 
                    $option = $model->getOption('cardio-anaerobic-speed');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#cardio-anaerobic-speed" class="accordion-title">
                        Cardio - Anaerobic Speed
                    </a>
                    <div class="accordion-content" data-tab-content id="cardio-anaerobic-speed">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[cardio-anaerobic-speed][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[cardio-anaerobic-speed][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="accordion-item" data-accordion-item>
                    <?php 
                    $option = $model->getOption('cardio-anaerobic-estimated-vo2');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#cardio-anaerobic-estimated-vo2" class="accordion-title">
                        Cardio - Anaerobic Estimated VO2
                    </a>
                    <div class="accordion-content" data-tab-content id="cardio-anaerobic-estimated-vo2">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[cardio-anaerobic-estimated-vo2][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[cardio-anaerobic-estimated-vo2][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                
                <li class="accordion-item" data-accordion-item>
                    <?php 
                    $option = $model->getOption('cardio-aerobic-heart-rate');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#cardio-aerobic-heart-rate" class="accordion-title">
                        Cardio - Aerobic Heart Rate
                    </a>
                    <div class="accordion-content" data-tab-content id="cardio-aerobic-heart-rate">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[cardio-aerobic-heart-rate][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[cardio-aerobic-heart-rate][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="accordion-item" data-accordion-item>
                    <?php 
                    $option = $model->getOption('cardio-aerobic-speed');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#cardio-aerobic-speed" class="accordion-title">
                        Cardio - Aerobic Speed
                    </a>
                    <div class="accordion-content" data-tab-content id="cardio-aerobic-speed">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[cardio-aerobic-speed][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[cardio-aerobic-speed][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="accordion-item" data-accordion-item>
                    <?php 
                    $option = $model->getOption('cardio-recovery');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#cardio-recovery" class="accordion-title">
                        Cardio - Recovery
                    </a>
                    <div class="accordion-content" data-tab-content id="cardio-recovery">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[cardio-recovery][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[cardio-recovery][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        
        <div class="white-block">
            <ul class="accordion" data-accordion>
                <li class="accordion-item is-active" data-accordion-item>
                    <?php 
                    $option = $model->getOption('strength-level');
                    $title = $option ? $option->value['title'] : '';
                    $content = $option ? $option->value['content'] : '';
                    ?>
                    <a href="#strength-level" class="accordion-title">
                        Strength - Strength Level
                    </a>
                    <div class="accordion-content" data-tab-content id="strength-level">
                        <div class="white-block">
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Title
                                    <?= Html::textInput('Options[strength-level][title]', $title) ?>
                                </label>
                            </div>
                            <div class="column large-12 medium-12 small-12 block">
                                <label>
                                    Content
                                    <?= Html::textarea('Options[strength-level][content]', $content, ['class' => 'textarea full-width', 'rows' => '8']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="float-right">
            <?= Html::submitButton('Save', ['class' => 'button alert btn-large btn-submit']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
