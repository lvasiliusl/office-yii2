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
?>
<?php Pjax::begin(['id' => 'balance']); ?>
<div class="page-title">
    <h3>New Balance</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
            <li>
                <a href="<?= Url::to(['/balance']); ?>">Balance</a>
            </li>
            <li class="active">New Balance</li>
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
                                    'class' => 'col-md-8 col-md-offset-2'
                                 ]
                            ]); ?>
                            <div class="form-group">
                                <label>Name</label>
                                <?= $form->field($model, 'name')->textInput(['class' => 'form-control'])->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Currency</label>
                                <?= $form->field($model, 'currency_id')->dropDownList($arrCurrencys)->label(false) ?>
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
