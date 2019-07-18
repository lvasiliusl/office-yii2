<?php
/* @var $this yii\web\View */
use yii\grid\DataColumn;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\grid\ActionColumn;


$this->registerJsFile('/admin/js/workout-form.js', ['depends' => 'yii\web\JqueryAsset']);;?>

<?php Pjax::begin(['id' => 'workout']); ?>
<div class="page-title">
    <h3>Workout</h3>

    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">Workout</li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <a href="<?= Url::to(['/workout/new-workout']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add New</a>
                <!-- </div> -->
                <!-- <div id="example_filter" class="dataTables_filter float-right"> -->
                    <label>Search: &nbsp;
                            <?php $form = ActiveForm::begin([
                                'options' => [ 'class' => 'search-area'],
                                'action' => Url::current(['s'=>NULL], true),
                                'method' => 'GET'
                            ]); ?>
                            <?= Html::textInput('s', Yii::$app->request->get('s'), ['class' => 'search-input']) ?>
                            <?php ActiveForm::end(); ?>
                    </label>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper">
                            <?php
                            $dataProvider = new ActiveDataProvider([
                                'query' => $workouts,
                                'pagination' => [
                                    'pageSize' => 20,
                                ],
                            ]);

                            echo GridView::widget([
                                'dataProvider'=> $dataProvider,
                                'tableOptions'=>['class'=>'display table dataTable'],

                                'columns' => [
                                    [
                                        'attribute' => 'user_id',
                                        'label'=>'User',
                                        'class' => DataColumn::className(),
                                        'value' => function ($model, $index, $widget) {
                                            return Html::a(
                                                Html::encode(ucfirst($model->user->first_name).' '.ucfirst($model->user->last_name)),
                                                Url::to( ['workout/user-workout', 'id' => $model->user->id] )
                                                );

                                        },
                                        'format' => 'text',
                                        'format' => 'raw',
                                    ],
                                    [
                                        'attribute' => 'project_id',
                                        'label'=>'Project',
                                        'class' => DataColumn::className(),
                                        'value' => function ($model, $index, $widget) {
                                            if ($model->project) {
                                                return ucfirst($model->project->name);
                                            } else {
                                                return '----------';
                                            }
                                        },
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'rate_type',
                                        'label'=>'Rate Type',
                                        'format' => 'text',
                                        'value' => function ($model, $index, $widget){
                                            if ($model->rate_type) {
                                                return ucfirst($model->rate_type);
                                            }
                                        },
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'hours',
                                        'label' => 'Hours',
                                        'format' => 'text',
                                        'value' => function ($model, $index, $widget){
                                            if ($model->hours) {
                                                return Yii::$app->formatter->asTime($model->hours, 'hh:mm');
                                            } else {
                                                return '----------';
                                            }
                                        },
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'rate',
                                        'label' => 'Rate',
                                        'value' => function ($model, $index, $widget){
                                            if ($model->rate) {
                                                return Yii::$app->formatter->asDecimal($model->rate);
                                            } else {
                                                return '----------';
                                            }
                                        },
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],

                                    [
                                        'attribute' => 'fixed',
                                        'label' => 'Fixed',
                                        'value' => function ($model, $index, $widget){
                                            if ($model->fixed) {
                                                return Yii::$app->formatter->asDecimal($model->fixed);
                                            } else {
                                                return '----------';
                                            }
                                        },
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
                                        'attribute' => 'description',
                                        'label' => 'Description',
                                        'format' => 'text',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'workout_date',
                                        'label' => 'Workout Date',
                                        'format' => 'date',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'attribute' => 'created_at',
                                        'label' => 'Created At',
                                        'format' => 'datetime',
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'label' => 'Summ',
                                        'format' => 'html',
                                        'value' => function ($model, $index, $widget){
                                            if ($model->rate) {
                                                $data = explode(':', $model->hours);
                                                $summ = $data['0'] * $model->rate +  $data['1']/60*$model->rate;
                                                return '<strong>' . Yii::$app->formatter->asDecimal($summ) . '</strong>';
                                            } elseif($model->fixed) {
                                                return '<strong>' . Yii::$app->formatter->asDecimal($model->fixed) . '</strong>';
                                            }else{
                                                return '----------';
                                            }
                                        },
                                        'contentOptions' => ['class' => 'sorting_asc'],
                                        'headerOptions' => ['class' => 'sorting_1'],
                                    ],
                                    [
                                        'class' => ActionColumn::className(),
                                        'template' => '{update}',
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
