<?php
/* @var $this yii\web\View */
/* @var $model common\models\Client */
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;
use common\models\Currency;
use common\helpers\SummHelper;

$this->title = 'Balance Transactions';?>
<?php Pjax::begin(['id' => 'balance_transactions']);?>
<div class="page-title">
    <h3>Balance Transactions</h3>

    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">Balance Transactions</li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <a href="<?= Url::to(['/balance-transactions/new-balance-transactions']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add New</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper">
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
                                        'attribute' => 'balance',
                                        'label'=>'Balance',
                                        'class' => DataColumn::className(),
                                        'value' => function ($model, $index, $widget) {
                                            return $model->officeBalance->name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'title',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'description',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'summ',
                                        'format' => 'html',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                        'class' => DataColumn::className(),
                                        'value' => function ($model, $index, $widget) {
                                            $qwe = SummHelper::curr($model->officeBalance->currency_id, $model->summ);
                                            return mb_strimwidth($model->title,0,14) == 'Transaction to' ? SummHelper::moneyFormatter('+' . $qwe) : SummHelper::moneyFormatter('-' . $qwe);
                                        }
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'format' => 'datetime',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'class' => ActionColumn::className(),
                                        'template' => '{delete}',
                                    ],
                                ],
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
