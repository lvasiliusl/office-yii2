<?php
/* @var $this yii\web\View */
/* @var $model common\models\Client */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\base\UserException;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;

use backend\assets\AppAsset;

$this->title = 'Clients';?>
<?php Pjax::begin(['id' => 'client']); ?>
<div class="page-title">
    <h3>Clients</h3>

    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">Clients</li>
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
                    <a href="<?= Url::to(['/client', 'page' => 'new-client']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add New</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper">
                            <!-- <div class="dataTables_length" id="example_length">
                                <label>Show
                                <select name="example_length" aria-controls="example" class="">
                                <option value="10">10</option><option value="25">25</option>
                                <option value="50">50</option><option value="100">100</option>
                                </select> entries</label>
                            </div> -->

                            <div id="example_filter" class="dataTables_filter float-right">
                                <label>Search:<?php $form = ActiveForm::begin([
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
                                'sort' => [
                                    'attributes' => [
                                        'projects_count' => [
                                            'asc' => ['projects_count' => SORT_ASC],
                                            'desc' => ['projects_count' => SORT_DESC],
                                            'label' => 'Projects',
                                            'default' => SORT_ASC
                                        ],

                                        'name' => [
                                            'asc' => ['name' => SORT_ASC],
                                            'desc' => ['name' => SORT_DESC],
                                            'label' => 'Name',
                                            'default' => SORT_ASC
                                        ],

                                        'email' => [
                                            'asc' => ['email' => SORT_ASC],
                                            'desc' => ['email' => SORT_DESC],
                                            'label' => 'Email',
                                            'default' => SORT_ASC
                                        ],

                                        'origin' => [
                                            'asc' => ['origin' => SORT_ASC],
                                            'desc' => ['origin' => SORT_DESC],
                                            'label' => 'Origin',
                                            'default' => SORT_ASC
                                        ],

                                        'defaultOrder' => [
                                            'desc' => ['name' => SORT_DESC],
                                        ],
                                    ],
                                ],
                            ]);

                            echo GridView::widget([
                                'dataProvider'=> $dataProvider,
                                'tableOptions'=>['class'=>'display table dataTable'],

                                'columns' => [
                                    [
                                        'attribute' => 'name',
                                        'value' => function ($data) {
                                            return Html::a(Html::encode($data->name), Url::to(['client/', 'client_id' => $data->id]));
                                        },
                                        'format' => 'text',
                                        'format' => 'raw',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'email',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'origin',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'label' => 'Projects',
                                        'attribute'=> 'projects_count',
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
