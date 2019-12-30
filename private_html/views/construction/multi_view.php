<?php

/* @var $this yii\web\View */
/* @var $project OtherConstruction */
/* @var $free Unit[] */
/* @var $sold Unit[] */

$baseUrl = $this->theme->baseUrl;

use app\controllers\ConstructionController;
use app\models\projects\OtherConstruction;
use app\models\Unit;

$sold = $project->getUnits()->andWhere([Unit::columnGetString('sold') => 1])->orderBy([Unit::columnGetString('sort') => SORT_ASC])->all();
$free = $project->getUnits()->andWhere([Unit::columnGetString('sold') => 0])->orderBy([Unit::columnGetString('sort') => SORT_ASC])->all();

?>
<section class="full-slide">
    <div class="container-fluid">
        <div class="row">
            <div class="slide-title">
                <div class="title-left">
                    <img src="<?= $baseUrl ?>/images/apartment-icon-w.png" alt="apartment-icon">
                    <div class="text">
                        <span class="slide"><strong><?= $project->getName() ?></strong></span><br>
                        <h2 class="slide"><?= trans('words', '<strong>available </strong> construction').' / '.$project->getSubtitleStr() ?></h2>
                    </div>
                </div>
                <div class="title-right">
                    <p class="slide">
                        <span class="projects"><?= trans('words', '{count} unit', ['count' => $project->getUnitCount()]) ?>
                            / </span>
                        <span class="available-project"><?= trans('words', 'available<br>unit') ?></span>
                        <span class="num"><?= $project->getUnitCount(true) ?></span>
                    </p>
                </div>
            </div>
            <div class="bg-slide" <?= $project->banner && is_file(alias('@webroot') . DIRECTORY_SEPARATOR . ConstructionController::$imgDir . DIRECTORY_SEPARATOR . $project->banner) ? 'style="background: url(\'' . alias('@web') . '/' . ConstructionController::$imgDir . '/' . $project->banner . '\') no-repeat center bottom;background-size:cover"' : '' ?>>
                <div class="bg-logo-slider">
                </div>
                <div class="center-title">
                    <h1 class="center-text"><?= $project->getName() ?></h1>
                    <h2 class="center-text"><?= $project->getSubtitleStr() ?></h2>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <ul class="icon-list-slider">
                            <?= $this->render('//site/_project_side', ['model' => $project]) ?>
                        </ul>
                    </div>
                </div>
                <?php if ($pdf_url = $project->getPdfUrl(ConstructionController::$pdfDir)): ?>
                    <div class="download">
                        <a href="<?= $pdf_url ?>">
                            <p><?= trans('words', 'Download As<br><strong>PDF</strong>') ?></p>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="content">
        <?php if ($free): ?>
            <div class="container">
                <div class="row">
                    <div class="available">
                        <div class="title">
                            <h2 class="available-title"><?= trans('words', '<strong>available</strong> for sell') ?></h2>
                        </div>
                        <div class="item-inner">
                            <?php foreach ($free as $unit): ?>
                                <div class="items collapsed" data-toggle="collapse" data-target="#item-<?= $unit->id ?>">
                                    <?= $this->render('//unit/_unit_items', ['model' => $unit]) ?>
                                    <div class="item link-more">
                                        <a class="more"><?= trans('words', 'More ...') ?></a>
                                    </div>
                                    <div id="item-<?= $unit->id ?>" class="item-list w-100 collapse" style="">
                                        <?= $this->render('//unit/_unit_details', ['model' => $unit]) ?>

                                        <div class="collapse-link-more">
                                            <a href="<?= $unit->getUrl() ?>"
                                               class="more"><?= trans('words', 'For more details ...') ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($sold): ?>
            <div class="container">
                <div class="row">
                    <div class="sold">
                        <div class="title">
                            <h2 class="sold-title"><?= trans('words', '<strong>sold</strong> units') ?></h2>
                        </div>
                        <div class="item-inner">
                            <?php foreach ($sold as $unit): ?>
                                <div class="items collapsed" data-toggle="collapse" data-target="#item-<?= $unit->id ?>">
                                    <?= $this->render('//unit/_unit_items', ['model' => $unit, 'sold' => true]) ?>
                                    <div class="item link-more">
                                        <a class="more"><?= trans('words', 'More ...') ?></a>
                                    </div>
                                    <div id="item-<?= $unit->id ?>" class="item-list w-100 collapse" style="">
                                        <?= $this->render('//unit/_unit_details', ['model' => $unit]) ?>

                                        <div class="collapse-link-more">
                                            <a href="<?= $unit->getUrl() ?>"
                                               class="more"><?= trans('words', 'For more details ...') ?></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

