<?php
/* @var $this yii\web\View */
/* @var $project common\models\Project */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\base\UserException;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use yii\jui\DatePicker;

use backend\assets\AppAsset;
$this->registerJsFile('/admin/js/workout-form.js', ['depends' => 'yii\web\JqueryAsset']);

$this->title = $model->id ? 'New Holidays' : 'Edit Holiday' ;?>
<?php Pjax::begin(['id' => 'holidays']); ?>
<div class="page-title">
    <h3>New Holiday</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
            <li>
                <a href="<?= Url::to(['/holidays']); ?>">Holidays</a>
            </li>
            <li class="active">New Holiday</li>
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
                            <?php $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'col-md-8 col-md-offset-2'
                                 ]
                            ]); ?>
                            <div class="form-group">
                                <label>Date</label>
                                <div class="form-inline">
                                    <?= $form->field($model, 'day')->textInput(
                                        [
                                            'class'     => 'form-control',
                                            'min'       => '1',
                                            'max'       => '31',
                                            'step'      => '1',
                                            'value'     => '',
                                            'type'      => 'number',
                                        ])->label(false) ?>
                                    <i>Day</i>
                                    <?=$form->field($model, 'month')->dropDownList([
                                        'January'   => 'January',
                                        'February'  => 'February',
                                        'March'     => 'March',
                                        'April'     => 'April',
                                        'May'       => 'May',
                                        'June'      => 'June',
                                        'July'      => 'July',
                                        'August'    => 'August',
                                        'September' => 'September',
                                        'October'   => 'October',
                                        'November'  => 'November',
                                        'December'  => 'December'
                                    ])->label(false) ?>
                                    <i>Month</i>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Descriprion</label>
                                <?= $form->field($model, 'description')->textArea(['class' => 'form-control'])->label(false) ?>
                            </div>
                            <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
                        <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Row -->
</div>
<?php Pjax::end(); ?>
