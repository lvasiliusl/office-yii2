<?php
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;

$this->title = 'Finance';

$dataProvider = new ActiveDataProvider([
    'query' => $model,
    'pagination' => [
        'pageSize' => 10,
    ],
]);
?>

<div class="page-title">
    <h3>Finance</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= Url::to(['/']); ?>">Home</a></li>
            <li class="active">Finance</li>
        </ol>
    </div>
</div>
<div id="main-wrapper">
    <div class="row">
        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'summary' => "",
            'itemView' => function ($model, $key, $index, $widget) {
                return $this->render('_balance_list_item', ['model' => $model]);
             }
        ]); ?>
    </div>
</div>
