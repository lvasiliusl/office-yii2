<?php
/* @var $this yii\web\View */
/* @var $model common\models\Client */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\base\UserException;
use yii\bootstrap\ActiveForm;

use backend\assets\AppAsset;

$this->title = 'New Client';?>
<?php Pjax::begin(['id' => 'client']); ?>
<div class="page-title">
    <h3>New Client</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li>
                <a href="<?= yii\helpers\Url::to(['/']); ?>">Clients</a>
            </li>
            <li class="active">New Client</li>
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
                                <label for="exampleInputEmail1">Name</label>
                                <?= $form->field($model, 'name')->textInput(['class' => 'form-control'])->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Email</label>
                                    <?= $form->field($model, 'email')->input('email',['class' => 'form-control'])->label(false)?>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Origin</label>
                                    <?= $form->field($model, 'origin')->textInput(['class' => 'form-control'])->label(false) ?>
                            </div>
                            <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
                        <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Row -->
</div>
<?php Pjax::end(); ?>
