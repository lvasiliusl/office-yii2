<?php
use backend\assets\AppAsset;
use backend\models\Rbac;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\helpers\Role;
use yii\bootstrap\ActiveForm;

$this->title = 'Add Permission';
?>
<div class="page-title">
    <h3>Permission</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">Add Permission</li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="title-row">
                <div class="panel-body">
                    <div class="panel panel-white">

                        <div class="table-responsive">
                            <table class="display table dataTable">
                                <thead>
                                    <?php $form = ActiveForm::begin(['options' => [ 'class' => 'search-area']]); ?>
                                    <tr>
                                        <th></th>
                                        <?php
                                        $roles = array();
                                        foreach( Yii::$app->getAuthManager()->getRoles() as $roleName ): ?>
                                            <th>
                                                <?= $roleName->name; ?>
                                            </th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <?= $form->field($model, 'name')->textInput(['class' => 'form-control'])->label(false) ?>
                                            </div>
                                        </td>
                                        <?php foreach( Yii::$app->getAuthManager()->getRoles() as $role ): ?>
                                            <td>
                                                <?=$form->field($model, 'roles['.$role->name.']')->dropDownList(['Disabled', 'Enabled'])->label(false)?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                </tbody>
                            </table>
                            <div class='savebutton'>
                            <?php echo Html::submitButton('Save', [
                                'class' => 'btn btn-success']);
                            ?>
                            </div>
                            <?php ActiveForm::end() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
