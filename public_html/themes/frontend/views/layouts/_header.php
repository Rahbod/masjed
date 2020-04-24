<?php
/** @var $this View */
/** @var string $baseUrl */

use app\components\MultiLangActiveRecord;
use app\components\Setting;
use app\models\Menu;
use yii\helpers\Url;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;
?>

<div class="logo-container">
    <div class="container">
        <a href="#" class="logo" title="مسجد جامع كربلا">
            <img src="<?= $this->theme->baseUrl.'/images/logo.png' ?>" alt="<?= app()->name ?>">
            <h1>
                <span class="arabic">مسجد جامع <span>كربلاء</span></span>
                <span class="english">Mosque <span>of Karbala</span></span>
            </h1>
        </a>
    </div>
</div>

<header>
    <div class="container">
        <nav class="navbar">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <a href="#" class="navbar-toggler">
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