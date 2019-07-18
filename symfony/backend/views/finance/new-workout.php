<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\ActiveForm;

$this->registerJsFile('/admin/js/workout-form.js', ['depends' => 'yii\web\JqueryAsset']);

$this->registerJsFile('/admin/plugins/jquery/jquery-2.1.4.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/jquery-ui/jquery-ui.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/pace-master/pace.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/jquery-blockui/jquery.blockui.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/bootstrap/js/bootstrap.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/jquery-slimscroll/jquery.slimscroll.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/switchery/switchery.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/uniform/jquery.uniform.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/offcanvasmenueffects/js/classie.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/offcanvasmenueffects/js/main.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/waves/waves.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/3d-bold-navigation/js/main.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/summernote-master/summernote.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/js/modern.min.js', ['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile('/admin/js/pages/form-elements.js', ['depends' => 'yii\web\JqueryAsset']);

$this->registerCssFile('/admin/plugins/uniform/css/uniform.default.min.css');
$this->registerCssFile('/admin/plugins/bootstrap-datepicker/css/datepicker3.css');
$this->registerCssFile('/admin/plugins/bootstrap-colorpicker/css/colorpicker.css');
$this->registerCssFile('/admin/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css');
$this->registerCssFile('/admin/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css');

$this->title = 'New Workout';?>

<?php Pjax::begin(['id' => 'new_workout']); ?>
<div class='page-title'>
    <h3>New Workout</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
            <li>
                <a href="<?= Url::to(['/workout']); ?>">Workout</a>
            </li>
            <li class="active">New Workout</li>
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
                            <?php if (empty($arrUsers)): ?>
                                <div class="alert alert-warning">
                                    <strong>Warning!</strong> Add user first.
                                    <a href="<?= Url::to(['/user/add']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add Balance</a>
                                    <div class="clearfix"></div>
                                </div>
                            <?php endif; ?>
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
                                <label>User</label>
                                <?= $form->field($model, 'user_id')->dropDownList($arrUsers)->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Project</label>
                                <?= $form->field($model, 'project_id')->dropDownList($arrProjects)->label(false) ?>
                            </div>
                            <div class="form-group">
                                <label>Rate Type</label>
                                <?= $form->field($model, 'rate_type')->dropDownList(['fixed' => 'Fixed', 'hourly' => 'Hourly'])->label(false) ?>
                            </div>

                            <div class="form-group">
                                <label class="control-label">Date</label>
                                <div class="field-workout-datepicker">
                                    <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" name="Workout[workout_date]">
                                </div>
                            </div>
                            <div id="fixed_type" class="form-group">
                                <label>Fixed</label>
                                <?= $form->field($model, 'fixed')->textInput(
                                    [
                                        'class' => 'form-control',
                                        'min' => '0',
                                        'max' => '99999',
                                        'step' => '1',
                                        'value' => '',
                                        'type' => 'number',
                                    ])->label(false) ?>
                            </div>

                            <div id="hourly_type" class="form-group hidden">
                                <div class="form-group">
                                    <label>Rate</label>
                                    <?= $form->field($model, 'rate')->textInput(
                                        [
                                            'class' => 'form-control',
                                            'min' => '0',
                                            'max' => '99',
                                            'step' => '1',
                                            'value' => '',
                                            'type' => 'number',
                                        ])->label(false) ?>
                                </div>
                                <div class="form-group">
                                    <label>Hours</label>
                                    <div class="form-inline">
                                        <?= $form->field($model, 'hours_h')->textInput(
                                            [
                                                'class' => 'form-control',
                                                'min' => '0',
                                                'max' => '23',
                                                'step' => '1',
                                                'value' => '',
                                                'type' => 'number',
                                            ])->label(false) ?>
                                        <i>hh</i>
                                        <?= $form->field($model, 'hours_m')->textInput(
                                            [
                                                'class' => 'form-control',
                                                'min' => '0',
                                                'max' => '59',
                                                'step' => '01',
                                                'value' => '',
                                                'type' => 'number',
                                            ])->label(false) ?>
                                        <i>mm</i>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Currency</label>
                                <?= $form->field($model, 'currency_id')->dropDownList($arrCurrencys)->label(false) ?>
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
    </div>
</div>
<?php Pjax::end(); ?>
<script>
var usersSalary = {
<?php foreach ($usersSalary as $key => $value): ?>
    <?= $key ?>: {
        salary: <?= $value['salary'] === Null ? '0' : $value['salary'] ?>,
        salary_type: <?= $value['salary_type'] === Null ? '"fixed"' : '"' . $value['salary_type'] . '"' ?>,
        currency_id: <?= $value['currency_id']?>,
    },
<?php endforeach; ?>};
</script>
