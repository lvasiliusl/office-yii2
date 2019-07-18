<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\base\UserException;
use yii\widgets\ListView;
use yii\widgets\ContentDecorator;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\grid\DataColumn;


$this->registerJsFile( '@web/plugins/d3/d3.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/d3/d3.layout.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/rickshaw/rickshaw.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/js/graph.js',['depends' => 'yii\web\JqueryAsset']);

$this->registerCssFile( '@web/plugins/rickshaw/rickshaw.min.css');
$this->registerCssFile( '@web/plugins/fullcalendar/fullcalendar.min.css');

$this->title = 'Salary'?>
<div class="page-title">
    <h3>Salary</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">Salary</li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-4 m-t-lg">
            <div class="panel info-box panel-white">
                <div class="panel-body">
                    <div class="info-box-stats">
                        <p class="counter">Progress</p>
                        <p><span class="lead">Salary: <?= round($userbalance->money_amount); ?> USD | <?= $model->salary_uah; ?> UAH</span></p>
                        <span><?= $hour; ?> out of <?= $monthmax; ?> hours</span>
                    </div>
                    <div class="info-box-icon text-right">
                        <i class="icon-wallet"></i>
                    </div>
                    <div class="info-box-progress">
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?= $percent?>" aria-valuemin="0" aria-valuemax="120" style="width: <?= $percent?>%;"></div>
                        </div>
                    </div>

                    <div class="info-box-progress">
                        <div class="progress">
                            <!-- <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="19" aria-valuemin="0" aria-valuemax="100" style="width: "<?=19 ?>"%;"></div> -->
                        </div>
                    </div>
                </div>
                <div class="savebutton text-right">
                    <a href="<?= Url::to(['#'])?>" class="btn btn-danger btn-sm">NEED MORE MONEY</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 m-t-lg">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="panel-title">Transaction</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => $transaction,
                                'pagination' => [
                                    'pageSize' => 3,
                                ],
                            ]);
                            echo GridView::widget([
                                'dataProvider'=> $dataProvider,
                                'tableOptions'=>['class'=>'display table dataTable'],

                                'columns' => [
                                  [
                                      'attribute' => 'summ',
                                      'format' => 'decimal',
                                      'contentOptions' => ['class' => 'sorting_asc'],
                                      'headerOptions' => ['class' => 'sorting_1'],
                                  ],
                                  [
                                      'attribute' => 'created_at',
                                      'format' => 'datetime',
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
        <div class="col-md-4 m-t-lg">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="panel-title">Workout</h4>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => $workout,
                                'pagination' => [
                                    'pageSize' => 3,
                                ],
                            ]);
                            echo GridView::widget([
                                'dataProvider'=> $dataProvider,
                                'tableOptions'=>['class'=>'display table dataTable'],

                                'columns' => [
                                  [
                                      'attribute' => 'rate_type',
                                      'label'=>'Rate Type',
                                      'format' => 'text',
                                      'contentOptions' => ['class' => 'sorting_asc'],
                                      'headerOptions' => ['class' => 'sorting_1'],
                                  ],
                                  [
                                      'attribute' => 'rate',
                                      'label' => 'Rate',
                                      'format' => 'text',
                                      'contentOptions' => ['class' => 'sorting_asc'],
                                      'headerOptions' => ['class' => 'sorting_1'],
                                  ],
                                  [
                                      'attribute' => 'fixed',
                                      'label' => 'Fixed',
                                      'format' => 'text',
                                      'contentOptions' => ['class' => 'sorting_asc'],
                                      'headerOptions' => ['class' => 'sorting_1'],
                                  ],
                                  [
                                      'attribute' => 'hours',
                                      'label' => 'Hours',
                                      'format' => 'text',
                                      'contentOptions' => ['class' => 'sorting_asc'],
                                      'headerOptions' => ['class' => 'sorting_1'],
                                  ],
                                  [
                                      'attribute' => 'project_id',
                                      'label' => 'Project',
                                      'class' => DataColumn::className(),
                                      'value' => function ($model, $index, $widget) {
                                          return $model->project->name;
                                      }
                                  ],
                                ],
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 m-t-lg">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h3 class="panel-title">Hour Per Day</h3>
                    <div class="text-right">
                        <?= Html::a('', ['salary/index', 'month' => $prev_month, 'side_month' => '-1', 'year' => $year], [ 'class' => 'fc-prev-button fc-button fc-state-default fc-corner-left fc-icon fc-icon-left-single-arrow'])?> <!--<span class=""></span></button>-->
                        <span><?= $model->date; ?></span>
                            <?= Html::a('', ['salary/index', 'month' => $next_month, 'side_month' => '+1', 'year' => $year], [ 'class' => 'fc-next-button fc-button fc-state-default fc-corner-right fc-icon fc-icon-right-single-arrow'])?><!-- <span class=""></span></button> -->
                    </div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<pre>

</pre>
<script type="text/javascript">
var dbdata_x = [];

dbdata_x = [
    <?php
    foreach ($hourly_month as $key => $value) {
        echo '{x:'.$key.',y:'.$value.'},';
    }
    ?>
];

var dbdata_y = [];

dbdata_y = [
    <?php
    foreach ($overwork as $key => $value) {
        echo '{x:'.$key.',y:'.$value.'},';
    }
    ?>
];

var month_days = <?= json_encode($month_days); ?>;
var week_days = {};
month_days.forEach((item, index) => {
    week_days[index] = item;
});
</script>
