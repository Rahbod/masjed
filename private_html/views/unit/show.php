<?php

use app\controllers\ApartmentController;
use app\models\projects\Apartment;
use app\models\Unit;
use yii\web\View;

/** @var View $this */
/** @var Unit $model */

$baseUrl = $this->theme->baseUrl;

$this->context->breadcrumbs = [
    trans('words', 'Available Apartments'),
    $model->getName(),
    $model->getSubtitleStr(),
];
?>
<div class="fade show">
    <div class="overly">
        <div class="item unit">
            <p class="title-1"><?= $model->area_size ?></p>
            <p class="title-2"><?= trans('words', 'Meters') ?></p>
        </div>
        <div class="item item-1">
            <img src="<?= $baseUrl ?>/images/item-1-w.png" alt="item-1">
        </div>
        <div class="item item-2">
            <img src="<?= $baseUrl ?>/images/item-2-w.png" alt="item-2">
        </div>
        <div class="item item-3">
            <img src="<?= $baseUrl ?>/images/item-3-w.png" alt="item-3">
        </div>
        <div class="item item-4">
            <img src="<?= $baseUrl ?>/images/item-4-w.png" alt="item-4">
        </div>
        <div class="item item-5">
            <img src="<?= $baseUrl ?>/images/item-5-w.png" alt="item-5">
        </div>
        <div class="item item-6">
            <img src="<?= $baseUrl ?>/images/item-6-w.png" alt="item-6">
        </div>
        <div class="item item-7">
            <img src="<?= $baseUrl ?>/images/item-7-w.png" alt="item-7">
        </div>
        <div class="item item-8">
            <img src="<?= $baseUrl ?>/images/item-8-w.png" alt="item-8">
        </div>
    </div>
    <?php if ($pdf_url = $model->project->getPdfUrl(ApartmentController::$pdfDir)): ?>
        <div class="download">
            <a href="<?= $pdf_url ?>">
                <p><?= trans('words', 'Download As<br><strong>PDF</strong>') ?></p>
            </a>
        </div>
    <?php endif; ?>
</div>
<?= $model->render($this) ?>

