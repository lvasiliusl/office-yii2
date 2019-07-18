<?php
use yii\helpers\Url;
use common\helpers\SummHelper;
?>

<div class="col-lg-4 col-md-6">
    <div class="panel info-box panel-white">
        <div class="panel-body">
            <div class="info-box-stats">
                <p><span class="counter"><a href="<?= Url::to(['/balance/edit', 'id' => $model->id]) ?>"><?= $model->name; ?></a></span></p>
            </div>
            <div class="info-box-icon">
                <i class="icon"><?= SummHelper::curr($model->currency_id, $model->money_amount); ?></i>
            </div>
        </div>
    </div>
</div>
