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
use yii\jui\DatePicker;
use yii\grid\GridView;

$this->registerJsFile( '@web/plugins/jquery/jquery-2.1.4.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/jquery-ui/jquery-ui.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/pace-master/pace.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/jquery-blockui/jquery.blockui.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/bootstrap/js/bootstrap.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/jquery-slimscroll/jquery.slimscroll.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/switchery/switchery.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/uniform/jquery.uniform.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/offcanvasmenueffects/js/classie.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/offcanvasmenueffects/js/main.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/3d-bold-navigation/js/main.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/fullcalendar/lib/moment.min.js',['depends' => 'yii\web\JqueryAsset']);
$this->registerJsFile( '@web/plugins/fullcalendar/fullcalendar.min.js',['depends' => 'yii\web\JqueryAsset']);

$this->registerJsFile( '@web/js/workout_calendar.js',['depends' => 'yii\web\JqueryAsset']);

$this->registerCssFile( '@web/plugins/fullcalendar/fullcalendar.min.css');

$this->title = 'Salary'?>
<?php Pjax::begin(['id' => 'salary']); ?>
<div class="page-title">
    <h3>Salary</h3>
    <div class="page-breadcrumb">
        <ol class="breadcrumb">
            <li><a href="<?= yii\helpers\Url::to(['/']); ?>">Home</a>
            </li>
            <li class="active">Salary</li>
        </ol>
    </div>
    <div class="row">
        <div class="col-md-12 m-t-lg">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="panel-title">Workout Calendar</h4>
                </div>
                <div class="panel-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="main-wrapper">

</div>
<script type="text/javascript">
var week_days = {};

week_days = [
    <?php
    foreach ($workout_calendar as $value) {
        echo '{title:' . '"' .  $value['0'] . '"' . ', start: new Date(' . $value['1'] . ')},';
    }
    ?>
];
</script>
<?php Pjax::end(); ?>
