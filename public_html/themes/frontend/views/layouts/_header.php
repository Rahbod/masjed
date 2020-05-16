<?php
/** @var $this View */
/** @var string $baseUrl */
/** @var bool $inner */

use app\components\MultiLangActiveRecord;
use app\components\Setting;
use app\models\Menu;
use yii\helpers\Url;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;
?>

<div class="logo-container">
    <div class="container">
        <a href="<?= Url::to(['/site/index'])?>" class="logo" title="<?= trans('words', 'Mosque of karbala') ?>">
            <img src="<?= $this->theme->baseUrl.'/images/logo.png' ?>" alt="<?= app()->name ?>">
            <h1>
                <span class="arabic"><?= trans('words', 'Great mosque') ?> <span><?= trans('words', 'karbala') ?></span></span>
                <span class="english"><?= trans('words', 'Great mosque') ?> <span><?= trans('words', 'of Karbala') ?></span></span>
            </h1>
        </a>
    </div>
</div>
<?php if(Yii::$app->controller->id == 'site' and Yii::$app->controller->action->id == 'index'):?>
    <div class="dropdown language-dropdown visible-xs">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown">عربي</a>
        <ul class="dropdown-menu dropdown-menu-left">
            <li><a href="#"><?= trans('words', 'fa')?></a></li>
            <li><a href="#"><?= trans('words', 'ar')?></a></li>
            <li><a href="#"><?= trans('words', 'en')?></a></li>
        </ul>
    </div>
<?php endif;?>
<header>
    <div class="container">
        <nav class="navbar">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a href="#" class="navbar-toggler hidden-xs">
                        <span class="bars-icon"></span>
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <?php
                        /** @var Menu $menu */
                        foreach (app()->controller->menus as $menu): ?>
                            <li<?= $menu->isActive()?' class="active"':'' ?>><a href="<?= $menu->getUrl()?>"<?= $menu->isAnchor()?' class="anchor-link"':'' ?><?= $menu->isAnchor()?' data-anchor="'.$menu->external_link.'"':'' ?>><?= $menu->getName() ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    </div>
</header>