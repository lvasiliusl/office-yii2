<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

$this->registerJsFile( 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js', ['depends' => 'yii\web\JqueryAsset'] );
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css');
$this->registerJsFile( '@web/js/auto-complete-client.js',['depends' => 'yii\web\JqueryAsset']);


$this->title = 'New Balance Transactions';?>
<?php Pjax::begin(['id' => 'new_balance_transactions']); ?>
<div class="page-title">
    <h3>New Balance Transactions</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
            <li>
                <a href="<?= Url::to(['/balance-transactions']); ?>">Balance Transactions</a>
            </li>
            <li class="active">New Balance Transactions</li>
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
                            <?php if (empty($arrBalances)): ?>
                                <div class="alert alert-warning">
                                    <strong>Warning!</strong> Add at least two balances first.
                                    <a href="<?= Url::to(['/balance/new-balance']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Balance</a>
                                    <div class="clearfix"></div>
                                </div>
                            <?php endif; ?>
                            <?php $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'col-md-8 col-md-offset-2'
                                 ]
                            ]); ?>
                            <div class="form-group">
                                <label>From Balance</label>
                                <?= $form->field($model, 'from_balance')->dropDownList($arrBalances)->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Summ</label>
                                <?= $form->field($model, 'from_summ')->textInput(
                                    [
                                        'class' => 'form-control',
                                        'min' => '0',
                                        'max' => '9999999',
                                        'step' => '0.01',
                                        'value' => '0',
                                        'type' => 'number',
                                        ])->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>To Balance</label>
                                <?= $form->field($model, 'to_balance')->dropDownList($arrBalances)->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Summ</label>
                                <?= $form->field($model, 'to_summ')->textInput(
                                    [
                                        'class' => 'form-control',
                                        'min' => '0',
                                        'max' => '9999999',
                                        'step' => '0.01',
                                        'value' => '0',
                                        'type' => 'number',
                                        ])->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <?= $form->field($model, 'description')->textInput(['class' => 'form-control'])->label(false) ?>
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
