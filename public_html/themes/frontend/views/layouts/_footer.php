<?php
/** @var $this View*/

use app\components\MultiLangActiveRecord;
use app\components\Setting;
use app\models\Menu;
use app\models\ProjectProcess;
use yii\helpers\Url;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;

$processes = ProjectProcess::getLastRows(4, 'id', SORT_ASC);
$processMoreLink = ProjectProcess::getMoreLink();
?>

<section class="footer hidden-xs">
    <div class="body-info">
        <?php if(Yii::$app->controller->id == 'site' and Yii::$app->controller->action->id == 'index'):?>
            <a href="#" class="navbar-toggler hidden-xs">
                <span class="bars-icon"></span>
            </a>
        <?php endif;?>
        <div class="right-side">
            <div class="logo-container">
                <a href="#" class="logo" title="<?= app()->name ?>">
                    <img src="<?= $this->theme->baseUrl.'/images/logo.png' ?>" alt="<?= app()->name ?>">
                    <?php if(app()->language == 'en'):?>
                        <h1>
                            <span class="arabic"><?= trans('words', 'karbala') ?> <span><?= trans('words', 'Great mosque') ?></span></span>
                            <span class="english"><?= trans('words', 'english_logo_desc') ?></span>
                        </h1>
                    <?php else:?>
                        <h1>
                            <span class="arabic"><?= trans('words', 'Great mosque') ?> <span><?= trans('words', 'karbala') ?></span></span>
                            <span class="english"><?= trans('words', 'Great mosque', [], 'en') ?> <span><?= trans('words', 'of Karbala', [], 'en') ?></span></span>
                        </h1>
                    <?php endif;?>
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
                <div><b>All Rights Reserved</b> Karbala great mosque</div>
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
                        <li><div><?= $process->getName() ?></div><b><?= $process->getDescriptionStr() ?></b><a href="<?= Url::to(['/process/archive?id=' . $process->id]) ?>" class="process-link"></a></li>
                    <?php endforeach; ?>
                    <li></li>
                    <li>
                        <a href="<?= Url::to(['/payment']) ?>" class="btn-donate">
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
<?php if(Yii::$app->controller->id == 'site' and Yii::$app->controller->action->id == 'index'):?>
    <div class="footer-mobile visible-xs">
        <a href="#" title="<?= app()->name ?>">
            <img src="<?= $this->theme->baseUrl.'/images/logo.png' ?>" alt="<?= app()->name ?>">
        </a>
        <div class="copyright">
            <div><b>All Rights Reserved</b> masjed jame karbala</div>
            <div><b>Design by</b> <a href="#">Tarsim.inc</a></div>
        </div>
    </div>
<?php endif;?>
<div class="mobile-footer-menu visible-xs">
    <a href="#" class="navbar-toggler">
        <span class="bars-icon"></span>
    </a>
    <?php if(Yii::$app->controller->id == 'site' and Yii::$app->controller->action->id == 'index'):?>
        <a href="#" class="mobile-menu-trigger"></a>
    <?php else:?>
        <a href="<?= Url::to(['/site/index'])?>" class="back-to-index-trigger"></a>
    <?php endif;?>
    <a href="<?= Url::to(['/payment']) ?>" class="btn-donate">
        <i class="svg-heart-white">
            <i class="svg-heart-filled-white"></i>
        </i>
    </a>
</div>