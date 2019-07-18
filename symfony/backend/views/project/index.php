<?php
/* @var $this yii\web\View */
/* @var $model common\models\Project */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\base\UserException;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;

use backend\assets\AppAsset;

$this->title = 'Projects';?>
<?php Pjax::begin(['id' => 'project']); ?>
<div class="page-title">
    <h3>Projects</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">Projects</li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title"><span><?= $this->title; ?></span>
                        <?php if( Yii::$app->request->get('search') ): ?><br>
                        <span>Search results for: <?= Yii::$app->request->get('search') ?><span>
                        <?php endif; ?>
                    </h4>
                    <a href="<?= yii\helpers\Url::to(['/project', 'page' => 'new-project']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add New</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper">
                            <div id="example_filter" class="dataTables_filter float-right">
                                <label>Search: &nbsp;
                                    <?php $form = ActiveForm::begin([
                                    'options' => ['type' => 'search'],
                                    'action' => Url::current(['search'=>NULL], true),
                                    'method' => 'GET'
                                ]); ?>
                                <?= Html::textInput('search', Yii::$app->request->get('search'), ['class' => 'search-input']) ?>
                                <?php ActiveForm::end(); ?></label>
                            </div>
                            <?php

                            $dataProvider = new ActiveDataProvider([
                                'query' => $model,
                                'pagination' => [
                                    'pageSize' => 20,
                                ],
                            ]);
                            echo GridView::widget([
                                'dataProvider'=> $dataProvider,
                                'tableOptions'=>['class'=>'display table dataTable'],

                                'columns' => [
                                    [
                                        'attribute' => 'name',
                                        'value' => function ($data) {
                                            return Html::a(Html::encode($data->name), Url::to(['project/', 'project_id' => $data->id]));
                                        },
                                        'format' => 'text',
                                        'format' => 'raw',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'price',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'clientName',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'label' => 'Creator',
                                        'attribute'=> 'userName',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                ],
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Row -->
</div>
<?php Pjax::end(); ?>
