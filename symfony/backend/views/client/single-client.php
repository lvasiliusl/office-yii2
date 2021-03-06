<?php
/* @var $this yii\web\View */
/* @var $model common\models\Client */
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\base\UserException;
use yii\widgets\ListView;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

use backend\assets\AppAsset;

$this->title = $model->name;?>
<?php Pjax::begin(['id' => 'client']); ?>
<div class="page-title">
    <h3>Client: <?= $model->name ?></h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
            <li>
                <a href="<?= Url::to(['/client']); ?>">Clients</a>
            </li>
            <li class="active"><?= $model->name ?></li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-3 user-profile client-profile">
            <h3 class="text-center"><?= $model->name?></h3>
            <ul class="list-unstyled text-center">
                <li><p><i class="fa fa-map-marker m-r-xs"></i><?= $model->origin?></p></li>
                <li><p><i class="fa fa-envelope m-r-xs"></i><a href="mailto:<?= $model->email?>"><?= $model->email?></a></p></li>
                <!-- <li><p><i class="fa fa-link m-r-xs"></i><a href="#">www.themeforest.net</a></p></li> -->
            </ul>
            <hr>
            <a href="<?= Url::to(['client/delete', 'id' => $model->id])?>"class="btn btn-danger btn-block"><i class="fa fa-minus m-r-xs"></i>Delete</a>
        </div>
        <div class="col-md-6 m-t-lg">
            <h2 class='non-margin-top'>Edit Client</h2>
            <div class="panel panel-white">
                <div class="panel-body">
                    <div class="post">
                        <?php $form = ActiveForm::begin(); ?>
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
                        <?= Html::submitButton('<i class="fa fa-save m-r-xs"></i> Save', ['class' => 'btn btn-success pull-right']) ?>
                    <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
            <div class="profile-timeline">
                <h2>Projects</h2>
                <ul class="list-unstyled">
                <?php
                    foreach ($model->projects as $project) :?>
                        <li class="timeline-item">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <div class="timeline-item-header">
                                        <p><?= $project->name?> </p>
                                    </div>
                                    <div class="timeline-item-post">
                                        <p><stong>Price: <stong><?= $project->price ?>USD</p>
                                        <p><stong>Creator: <stong>Admin</p>
                                        <p><?= $project->description ?></p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach?>
                    <?php foreach ($model->projects as $project) :?>
                        <li class="timeline-item">
                            <div class="panel panel-white">
                                <div class="panel-body">
                                    <div class="timeline-item-header">
                                        <p><?= $project->name?> </p>
                                    </div>
                                    <div class="timeline-item-post">
                                        <p><stong>Price: <stong><?= $project->price ?>USD</p>
                                        <p><stong>Creator: <stong>Admin</p>
                                        <p><?= $project->description ?></p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
