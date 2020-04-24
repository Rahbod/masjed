<?php
/** @var $this View*/

use app\components\MultiLangActiveRecord;
use app\components\Setting;
use app\models\Menu;
use app\models\ProjectProcess;
use yii\helpers\Url;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;

$processes = ProjectProcess::getLastRows(4);
$processMoreLink = ProjectProcess::getMoreLink();
?>

<section class="footer">
    <div class="body-info">
        <div class="right-side">
            <div class="logo-container">
                <a href="#" class="logo" title="<?= app()->name ?>">
                    <img src="<?= $this->theme->baseUrl.'/images/logo.png' ?>" alt="<?= app()->name ?>">
                    <h1>
                        <span class="arabic">مسجد جامع <span>كربلاء</span></span>
                        <span class="english">Mosque <span>of Karbala</span></span>
                    </h1>
                </a>
            </div>
            <nav class="navbar">
                <div class="container-fluid">
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php
                            /** @var Menu $menu */
                            foreach (app()->controller->menus as $menu): ?>
                                <li<?= $menu->isActive()?' class="active"':'' ?>><a href="<?= $menu->getUrl()?>"><?= $menu->getName() ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="copyright">
                <div><b>All Rights Reserved</b> masjed jame karbala</div>
                <div><b>Design by</b> <a href="https://tarsiminc.com/">Tarsim.inc</a></div>
            </div>
        </div>
        <div class="left-side">
            <div class="report">
                <h3 class="dark-red"><i></i><?= trans('words', 'Project implementation process') ?></h3>
                <ul>
                    <?php
                    /** @var ProjectProcess[] $processes */
                    foreach ($processes as $process): ?>
                        <li><div><?= $process->getName() ?></div><b><?= $process->getDescriptionStr() ?></b></li>
                    <?php endforeach; ?>
                    <li></li>
                    <li>
                        <a href="#" class="btn-donate">
                            <?= trans('words', '<b>Donate</b> now') ?>
                            <i class="left-side--btn__heart svg-heart-r">
                                <i class="left-side--btn__heart-inner svg-heart-filled-r"></i>
                            </i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>