<?php
/* @var $this yii\web\View */
/* @var $project common\models\Project */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;


$this->registerJsFile( 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js', ['depends' => 'yii\web\JqueryAsset'] );
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css');
$this->registerJsFile( '@web/js/auto-complete-client.js',['depends' => 'yii\web\JqueryAsset']);


$this->title = 'New Project';?>
<?php Pjax::begin(['id' => 'project']); ?>
<div class="page-title">
    <h3>New Project</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li>
                <a href="<?= yii\helpers\Url::to(['/project']); ?>">Projects</a>
            </li>
            <li class="active">New Project</li>
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
                                <label>Name</label>
                                <?= $form->field($project, 'name')->textInput(['class' => 'form-control'])->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Client</label>
                                <?= $form->field($project, 'client_id')->dropdownList(
                                    [],
                                    [
                                        'class' => 'form-control clients-autocomplete',
                                        'data-source' => yii\helpers\Url::to(['/client/auto-complete'])
                                    ]
                                )->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <?= $form->field($project, 'price')->textInput(['class' => 'form-control'])->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Descriprion</label>
                                <?= $form->field($project, 'description')->textArea(['class' => 'form-control'])->label(false) ?>
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
