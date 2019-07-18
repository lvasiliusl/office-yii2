<?php
/* @var $this yii\web\View */
/* @var $model common\models\Project */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

$this->registerJsFile( 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js', ['depends' => 'yii\web\JqueryAsset'] );
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css');
$this->registerJsFile( '@web/js/auto-complete-client.js',['depends' => 'yii\web\JqueryAsset']);


$this->title = 'New Currency';?>
<?php Pjax::begin(['id' => 'currency']); ?>
<div class="page-title">
    <h3>New Currency</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
            <li>
                <a href="<?= Url::to(['/currency']); ?>">Currency</a>
            </li>
            <li class="active">New Currency</li>
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
                                <label>Title</label>
                                <?= $form->field($model, 'title')->textInput(['class' => 'form-control'])->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Code</label>
                                <?= $form->field($model, 'code')->textInput(['class' => 'form-control'])->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Symbol</label>
                                <?= $form->field($model, 'symbol')->textInput(['class' => 'form-control'])->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Symbol Position</label>
                                <?= $form->field($model, 'symbol_position')->textInput(['class' => 'form-control'])->label(false) ?>
                            </div>

                            <?= Html::submitButton('Add', ['class' => 'btn btn-primary']) ?>
                        <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
