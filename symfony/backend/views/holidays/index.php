<?php
/* @var $this yii\web\View */
/* @var $model common\models\User */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\base\UserException;
use yii\widgets\ListView;
use yii\widgets\ContentDecorator;
use yii\bootstrap\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = 'Holidays';?>
<?php Pjax::begin(['id' => 'holidays']); ?>
<div class="page-title">
    <h3><?= $this->title ?></h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li>
                <a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active"><?= $this->title ?></li>
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
                            <a href="<?= yii\helpers\Url::to(['holidays/add']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add New</a>
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => $model,
                                'pagination' => [
                                    'pageSize' => 10,
                                ],
                            ]);
                            echo GridView::widget([
                                'dataProvider'=> $dataProvider,
                                'tableOptions'=>['class'=>'display table dataTable'],

                                'columns' => [
                                    [
                                        'attribute' => 'day',
                                        'label' => 'Day',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'month',
                                        'label' => 'Month',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'description',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                        'label' => 'Name',
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
