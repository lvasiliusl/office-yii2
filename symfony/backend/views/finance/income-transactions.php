<?php
/* @var $this yii\web\View */
/* @var $model common\models\Client */
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\grid\ActionColumn;
use yii\grid\DataColumn;

$this->title = 'Income Transactions';?>
<?php Pjax::begin(['id' => 'income_transactions']); ?>
<div class="page-title">
    <h3>Income Transactions</h3>

    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">Income Transactions</li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <a href="<?= Url::to(['/income-transactions/new-income-transactions']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add New</a>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => $incomeTransactions,
                                'pagination' => [
                                    'pageSize' => 20,
                                ],
                            ]);

                            echo GridView::widget([
                                'dataProvider'=> $dataProvider,
                                'tableOptions'=>['class'=>'display table dataTable'],

                                'columns' => [
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
                                        'attribute' => 'from',
                                        'label'=>'From',
                                        'class' => DataColumn::className(),
                                        'value' => function ($model, $index, $widget) {
                                            return $model->incomeSource->name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'to_balance',
                                        'label'=>'Target Balance',
                                        'class' => DataColumn::className(),
                                        'value' => function ($model, $index, $widget) {
                                            return $model->officeBalance->name;
                                        }
                                    ],
                                    [
                                        'attribute' => 'summ',
                                        'format' => 'decimal',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'currency_id',
                                        'label'=>'Currency',
                                        'class' => DataColumn::className(),
                                        'value' => function ($model, $index, $widget) {
                                            return $model->currency->code;
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
