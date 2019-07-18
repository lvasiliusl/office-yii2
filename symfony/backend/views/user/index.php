<?php
/* @var $this yii\web\View */
/* @var $query common\models\User */
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;
use yii\base\UserException;
use common\models\User;
use common\models\UserBalance;
use backend\assets\AppAsset;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\DataColumn;
use common\helpers\Role;
use yii\helpers\ArrayHelper;


$model= User::find();
$this->title = 'Users';
?>
<?php Pjax::begin(['id' => 'user']); ?>
<div class="page-title">
    <h3>Users</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">Users</li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">
                        <?php if( Yii::$app->request->get('search') ): ?><br>
                        <span>Search results for:&nbsp; <?= Yii::$app->request->get('search') ?><span>
                        <?php endif; ?>
                    </h4>
                    <a href="<?= yii\helpers\Url::to(['user/add']); ?>" class="btn btn-success float-right"><i class="fa fa-plus"></i> Add New</a>
                    <div id="example_filter" class="dataTables_filter float-left">
                        <label>Show: &nbsp;
                            <?php $form = ActiveForm::begin(['method' => 'GET']);?>
                            <?= Html::a('All', ['user/index'], [ 'class' => 'font-weight-normal' ])?>
                            <?php foreach ( Yii::$app->getAuthManager()->getRoles() as $roleName ): ?>
                                <?= '| ' . Html::a(ucfirst($roleName->name), ['user/index', 'role' => $roleName->name], [ 'class' => 'font-weight-normal'])?>
                            <?php endforeach; ?>
                            <?php ActiveForm::end(); ?>
                            </label>
                        </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <div id="example_wrapper" class="dataTables_wrapper">
                            <div id="example_filter" class="dataTables_filter float-right">
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
                        <?php
                        $dataProvider = new ActiveDataProvider([
                            'query' => $query,
                            'pagination' => [
                                'pageSize' =>10,
                                ],
                            'sort' => [
                                'attributes' => [
                                    'Display_name' => [
                                        'asc' => ['first_name' => SORT_ASC, 'last_name' => SORT_ASC],
                                        'desc' => ['first_name' => SORT_DESC, 'last_name' => SORT_DESC],
                                        'label' => 'Name',
                                        'default' => SORT_ASC
                                    ],
                                    'created_at' => [
                                        'asc' => ['created_at' => SORT_ASC],
                                        'desc' => ['created_at' => SORT_DESC],
                                        'label' => 'Registered',
                                        'default' => SORT_ASC
                                    ],
                                    'salary' => [
                                        'asc' => ['salary' => SORT_ASC],
                                        'desc' => ['salary' => SORT_DESC],
                                        'label' => 'salary',
                                        'default' => SORT_ASC
                                    ],
                                    'Money Amount' => [
                                        'asc' => ['Money Amount' => SORT_ASC],
                                        'desc' => ['Money Amount' => SORT_DESC],
                                        'label' => 'Money Amount',
                                        'default' => SORT_ASC
                                    ],
                                    'defaultOrder' => [
                                        'Display_name' => SORT_ASC,
                                    ],
                                ],
                            ],
                        ]);
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'tableOptions' => ['class'=>'display table dataTable'],
                            'columns' => [
                                [
                                    'attribute' => 'Display_name',
                                    'value' => function ($data) {
                                        return Html::a(
                                            Html::encode( $data->first_name . ' ' . $data->last_name ),
                                            Url::to( ['user/edit', 'id' => $data->id] )
                                        );
                                    },
                                    'format' => 'text',
                                    'format' => 'raw',

                                ],
                                [
                                    'attribute' => 'email',
                                    'format' => 'text',
                                ],
                                [
                                    'attribute' => 'created_at',
                                    'format' => ['date', 'php:d-m-Y'] ,
                                ],
                                [
                                    'attribute' => 'role',
                                    'value' => function($data) {
                                        return Html::encode( ucfirst(key(Yii::$app->authManager->getRolesByUser($data->id))));
                                    },
                                    'format' => 'text',
                                ],
                                [
                                    'attribute' => 'salary_type',
                                    'format' => 'text',
                                ],
                                [
                                    'attribute' => 'salary',
                                    'value' => function ($data) {
                                        return Html::encode( $data->salary );
                                    },
                                    'format' => 'text'
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
                                    'label'=>'Money Amount',
                                    'contentOptions' => ['class' => 'sorting_asc'],
                                    'headerOptions' => ['class' => 'sorting_1'],
                                    'class' => DataColumn::className(),
                                    'value' => function ($data) {
                                        $money_amount = ArrayHelper::toArray(UserBalance::findOne(['user_id' => $data->id]))['money_amount'];
                                        return Yii::$app->formatter->asDecimal($money_amount);
                                    }
                                ],
                            ],
                        ]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Row -->
</div>
<?php Pjax::end(); ?>
