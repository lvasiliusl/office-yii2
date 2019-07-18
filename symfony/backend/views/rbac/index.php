<?php
use yii\bootstrap\ActiveForm;
use backend\assets\AppAsset;
use backend\models\Rbac;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\helpers\Role;

$this->title = 'Roles';
?>
<div class="page-title">
    <h3>Roles</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">RolesRules</li>
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
                                    <?= Html::beginForm(['rbac/index']) ?>
                                    <tr>
                                        <th>
                                            <a class='btn btn-info' href='<?= yii\helpers\Url::to(['permission-form/index']); ?>'>Add permission</a>
                                        </th>
                                        <th>
                                            Permission
                                        </th>
                                        <?php
                                        $roles = array();
                                        foreach( Yii::$app->getAuthManager()->getRoles() as $roleName ): ?>
                                            <th>
                                                <?php $roles[] = $roleName->name; ?>
                                                <?= $roleName->name; ?>
                                            </th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( Yii::$app->getAuthManager()->getPermissions() as $permission ):?>
                                    <tr>
                                        <td>
                                            <a href="<?= Url::to(['rbac/delete', 'delete' => $permission->name])?>" class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                        <td><?=$permission->name?></td>
                                        <?php foreach( Yii::$app->getAuthManager()->getRoles() as $role ): ?>
                                            <td>
                                                <?= Html::dropDownList(
                                                    'Role['.$role->name.']['.$permission->name.']',
                                                    (int)Role::hasPermission($role->name, $permission->name),
                                                    ['Disabled', 'Enabled'],
                                                    ['class' => 'form-control']
                                                );?>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class='savebutton'>
                            <?php echo Html::submitButton('Save', [
                                'name' => 'Save',
                                'class' => 'btn btn-success']);
                            ?>
                            </div>
                            <?= Html::endForm() ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
