<?php
/** @var $this View */
/** @var $block Banner */
/** @var $project Project */

use app\controllers\BlockController;
use app\models\blocks\Banner;
use app\models\Project;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;
$imageUrl = request()->getBaseUrl().'/'.BlockController::$imgDir.'/'.$block->image;
?>
<section class="full-slide" style="background: url('<?= $imageUrl ?>') no-repeat center bottom;background-size: cover">
    <div class="container-fluid">
        <div class="row">
            <div class="bg-slide">
                <div class="bg-logo-slider">
                </div>
                <?php if($project->type != Project::TYPE_INVESTMENT): ?>
                    <div class="center-title">
                        <h1 class="center-text"><?= $project->unit?$project->unit->getName():$project->getName() ?></h1>
                        <h2 class="center-text"><?= $project->getSubtitleStr() ?></h2>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <ul class="icon-list-slider">
                                <div class="item item-1">
                                    <div class="inner">
                                        <p class="item-text-hover"><?= '1' ?></p>
                                        <img src="<?= $baseUrl ?>/images/item-7.png" alt="item-7">
                                    </div>
                                </div>
                                <div class="item item-2">
                                    <div class="inner">
                                        <p class="item-text-hover"><?= '1' ?></p>
                                        <img src="<?= $baseUrl ?>/images/item-4.png" alt="item-3">
                                    </div>
                                </div>
                                <div class="item item-3">
                                    <div class="inner">
                                        <p class="item-text-hover"><?= '1' ?></p>
                                        <img src="<?= $baseUrl ?>/images/item-6.png" alt="item-6">
                                    </div>
                                </div>
                                <div class="item item-4">
                                    <div class="inner">
                                        <p class="item-text-hover"><?= '1' ?></p>
                                        <img src="<?= $baseUrl ?>/images/item-5.png" alt="item-4">
                                    </div>
                                </div>
                                <div class="item center-icon">
                                    <div class="inner">
                                        <p class="title-center-icon-1"><?= $project->area_size ?></p>
                                        <p class="title-center-icon-2"><?= trans('words', 'Meters') ?></p>
                                    </div>
                                </div>
                                <div class="item item-5">
                                    <div class="inner">
                                        <p class="item-text-hover"><?= '1' ?></p>
                                        <img src="<?= $baseUrl ?>/images/item-2.png" alt="item-2">
                                    </div>
                                </div>
                                <div class="item item-6">
                                    <div class="inner">
                                        <p class="item-text-hover"><?= '1' ?></p>
                                        <img src="<?= $baseUrl ?>/images/item-9.png" alt="item-9">
                                    </div>
                                </div>
                                <div class="item item-7">
                                    <div class="inner">
                                        <p class="item-text-hover"><?= '1' ?></p>
                                        <img src="<?= $baseUrl ?>/images/item-3.png" alt="item-3">
                                    </div>
                                </div>
                                <div class="item item-8">
                                    <div class="inner">
                                        <p class="item-text-hover"><?= '1' ?></p>
                                        <img src="<?= $baseUrl ?>/images/item-10.png" alt="item-10">
                                    </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>