<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\User;
use common\helpers\Gravatar;
use yii\widgets\Menu;

AppAsset::register($this);
?>
<?php $this->beginPage();
$current_user = User::findOne(['id' => Yii::$app->user->id]);
$current_user_role = ucfirst(key(Yii::$app->authManager->getRolesByUser(Yii::$app->user->id)));

$activeTab = function ($controller) {
    return $controller === $this->context->getUniqueId() ? 'active' : '';
};

?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<div class="overlay"></div>
<div class="menu-wrap">
    <nav class="profile-menu">
        <div class="profile"><img src=" <?= Gravatar::getGravatarUrl($current_user['email'], 60); ?> " width="60" alt="David Green"/><span><?= $current_user->first_name ?></span></div>
        <div class="profile-menu-list">
            <a href="#"><i class="fa fa-star"></i><span>Favorites</span></a>
            <a href="#"><i class="fa fa-bell"></i><span>Alerts</span></a>
            <a href="#"><i class="fa fa-envelope"></i><span>Messages</span></a>
            <a href="#"><i class="fa fa-comment"></i><span>Comments</span></a>
        </div>
    </nav>
    <button class="close-button" id="close-button">Close Menu</button>
</div>
<form class="search-form" action="#" method="GET">
    <div class="input-group">
        <input type="text" name="search" class="form-control search-input" placeholder="Search...">
        <span class="input-group-btn">
            <button class="btn btn-default close-search waves-effect waves-button waves-classic" type="button"><i class="fa fa-times"></i></button>
        </span>
    </div><!-- Input Group -->
</form><!-- Search Form -->
<main class="page-content content-wrap">
    <div class="navbar">
        <div class="navbar-inner">
            <div class="sidebar-pusher">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic push-sidebar">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="logo-box">
                <a href="" class="logo-text"><span>Modern</span></a>
            </div><!-- Logo Box -->
            <div class="search-button">
                <a href="javascript:void(0);" class="waves-effect waves-button waves-classic show-search"><i class="fa fa-search"></i></a>
            </div>
            <div class="topmenu-outer">
                <div class="top-menu">
                    <ul class="nav navbar-nav navbar-left">
                        <li>
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic sidebar-toggle"><i class="fa fa-bars"></i></a>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="waves-effect waves-button waves-classic toggle-fullscreen"><i class="fa fa-expand"></i></a>
                        </li>

                    </ul>
                    <ul class="nav navbar-nav navbar-right">

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle waves-effect waves-button waves-classic" data-toggle="dropdown">
                                <span class="user-name"><?= $current_user->first_name?><i class="fa fa-angle-down"></i></span>
                                <img class="img-circle avatar" src=" <?= Gravatar::getGravatarUrl($current_user['email'], 40); ?> " width="40" height="40" alt="">
                            </a>
                            <ul class="dropdown-menu dropdown-list" role="menu">
                                <li role="presentation">
                                    <a href="<?= yii\helpers\Url::to([ 'profile/index' ]); ?>"><i class="fa fa-user"></i>Profile</a>
                                </li>
                                <li role="presentation"><a href="<?= yii\helpers\Url::to([ 'workout/index' ]); ?>"><i class="fa fa-calendar"></i>Calendar</a></li>
                                <li role="presentation" class="divider"></li>
                                <!-- <li role="presentation"><a href="lock-screen.html"><i class="fa fa-lock"></i>Lock screen</a></li> -->
                                <li role="presentation">
                                    <a href="<?= yii\helpers\Url::to([ 'site/logout' ]); ?>"><i class="fa fa-sign-out m-r-xs"></i>Log out</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= yii\helpers\Url::to(['site/logout']); ?>" class="log-out waves-effect waves-button waves-classic">
                                <span><i class="fa fa-sign-out m-r-xs"></i>Log out</span>
                            </a>
                        </li>

                    </ul><!-- Nav -->
                </div><!-- Top Menu -->
            </div>
        </div>
    </div><!-- Navbar -->
    <div class="page-sidebar sidebar">
        <div class="page-sidebar-inner slimscroll">
            <div class="sidebar-header">
                <div class="sidebar-profile">
                    <a href="javascript:void(0);" id="profile-menu-link">
                        <div class="sidebar-profile-image">
                            <img src=" <?= Gravatar::getGravatarUrl($current_user['email'], 100); ?> " class="img-circle img-responsive" alt="">
                        </div>
                        <div class="sidebar-profile-details">
                            <span><?= $current_user->first_name . ' ' .  $current_user->last_name?><br><small><?=$current_user_role?></small></span>
                        </div>
                    </a>
                </div>
            </div>
                <ul class="menu accordion-menu">
                    <?php echo Menu::widget([
                        'options' => ['tag' => false],
                        'items' => [
                            ['label' => 'Dashboard', 'url' => ['/'], 'template' => '<a href="{url}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-home"></span><p>{label}</p></a>'],
                            ['label' => 'Users', 'url' => ['/user'], 'template' => '<a href="{url}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-user"></span><p>{label}</p></a>'],
                            ['label' => 'Finance',
                                'options' => ['class' => 'droplink '],
                                'template' => '<a href="#" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-bitcoin"></span><p>{label}</p><span class="arrow"></span></a>',
                                'items' => [
                                    ['label' => 'Finance', 'url' => ['/finance'], 'template' => '<a href="{url}" class="waves-effect waves-button"><p>{label}</p></a>'],
                                    ['label' => 'Workout', 'url' => ['/workout'], 'template' => '<a href="{url}" class="waves-effect waves-button"><p>{label}</p></a>'],
                                    ['label' => 'Balance', 'url' => ['/balance'], 'template' => '<a href="{url}" class="waves-effect waves-button"><p>{label}</p></a>'],
                                    ['label' => 'Balance Transaction', 'url' => ['/balance-transactions'], 'template' => '<a href="{url}" class="waves-effect waves-button"><p>{label}</p></a>'],
                                    ['label' => 'Income Source', 'url' => ['/income-source'], 'template' => '<a href="{url}" class="waves-effect waves-button"><p>{label}</p></a>'],
                                    ['label' => 'Income Transactions', 'url' => ['/income-transactions'], 'template' => '<a href="{url}" class="waves-effect waves-button"><p>{label}</p></a>'],
                                    ['label' => 'Currency', 'url' => ['/currency'], 'template' => '<a href="{url}" class="waves-effect waves-button"><p>{label}</p></a>'],
                                    ['label' => 'Currency Exchange', 'url' => ['/currency-exchange'], 'template' => '<a href="{url}" class="waves-effect waves-button"><p>{label}</p></a>'],
                                ]
                            ],
                            ['label' => 'Roles and Premission', 'url' => ['/rbac'], 'template' => '<a href="{url}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-user"></span><p>{label}</p></a>'],
                            ['label' => 'Clients', 'url' => ['/client'], 'template' => '<a href="{url}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-user"></span><p>{label}</p></a>'],
                            ['label' => 'Projects', 'url' => ['/project'], 'template' => '<a href="{url}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-briefcase"></span><p>{label}</p></a>'],
                            ['label' => 'Holidays', 'url' => ['/holidays'], 'template' => '<a href="{url}" class="waves-effect waves-button"><span class="menu-icon glyphicon glyphicon-calendar"></span><p>{label}</p></a>'],
                        ],
                        'submenuTemplate' => "\n<ul class='sub-menu'>\n{items}\n</ul>\n",
                        ]);
                    ?>
                </ul>
            </div><!-- Page Sidebar Inner -->
        </div><!-- Page Sidebar -->
        <div class="page-inner">
            <?= $content ?>
            <div class="page-footer">
                <p class="no-s"><?= date('Y') ?> &copy; Webbee.pro</p>
            </div>
        </div>
    </main><!-- Page Content -->
    <nav class="cd-nav-container" id="cd-nav">
        <header>
            <h3>Navigation</h3>
            <a href="#0" class="cd-close-nav">Close</a>
        </header>
        <ul class="cd-nav list-unstyled">
            <li class="cd-selected" data-menu="index">
                <a href="javsacript:void(0);">
                    <span>
                        <i class="glyphicon glyphicon-home"></i>
                    </span>
                    <p>Dashboard</p>
                </a>
            </li>
            <li data-menu="profile">
                <a href="javsacript:void(0);">
                    <span>
                        <i class="glyphicon glyphicon-user"></i>
                    </span>
                    <p>Profile</p>
                </a>
            </li>
            <li data-menu="inbox">
                <a href="javsacript:void(0);">
                    <span>
                        <i class="glyphicon glyphicon-envelope"></i>
                    </span>
                    <p>Mailbox</p>
                </a>
            </li>
            <li data-menu="#">
                <a href="javsacript:void(0);">
                    <span>
                        <i class="glyphicon glyphicon-tasks"></i>
                    </span>
                    <p>Tasks</p>
                </a>
            </li>
            <li data-menu="#">
                <a href="javsacript:void(0);">
                    <span>
                        <i class="glyphicon glyphicon-cog"></i>
                    </span>
                    <p>Settings</p>
                </a>
            </li>
            <li data-menu="calendar">
                <a href="javsacript:void(0);">
                    <span>
                        <i class="glyphicon glyphicon-calendar"></i>
                    </span>
                    <p>Calendar</p>
                </a>
            </li>
        </ul>
    </nav>
    <div class="cd-overlay"></div>
<?php $this->endBody() ?>
<?php $this->endPage() ?>
</body>
</html>
