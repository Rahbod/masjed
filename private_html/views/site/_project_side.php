<?php
/** @var $this View */
/** @var $model Project */

/** @var $withValue bool */

use app\models\Project;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;
$withValue = isset($withValue) ? $withValue : false;
?>
<?php if (!$withValue): ?>
    <div class="item unit">
        <p class="title-1"><?= $model->area_size ?></p>
        <p class="title-2"><?= trans('words', 'Meters') ?></p>
    </div>
    <?php if ($model->hasField('elevator')): ?>
        <div class="item item-1">
        <img src="<?= $baseUrl . '/images/item-1-w.png' ?>"
             alt="item-1">
        </div><?php endif; ?>
    <?php if ($model->hasField('parking')): ?>
        <div class="item item-2">
        <img src="<?= $baseUrl . '/images/item-2-w.png' ?>"
             alt="item-2">
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-3">
        <img src="<?= $baseUrl . '/images/item-3-w.png' ?>"
             alt="item-3">
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-4">
        <img src="<?= $baseUrl . '/images/item-4-w.png' ?>"
             alt="item-4">
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-5">
        <img src="<?= $baseUrl . '/images/item-5-w.png' ?>"
             alt="item-5">
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-6">
        <img src="<?= $baseUrl . '/images/item-6-w.png' ?>"
             alt="item-6">
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-7">
        <img src="<?= $baseUrl . '/images/item-7-w.png' ?>"
             alt="item-7">
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-8">
        <img src="<?= $baseUrl . '/images/item-8-w.png' ?>"
             alt="item-8">
        </div><?php endif; ?>
<?php else: ?>
    <?php if ($model->hasField('elevator')): ?>
        <div class="item item-1">
        <div class="inner">
            <p class="item-text-hover"><?= '1' ?></p>
            <img src="<?= $baseUrl . '/images/item-7.png' ?>" alt="item-7">
        </div>
        </div><?php endif; ?>
    <?php if ($model->hasField('parking')): ?>
        <div class="item item-2">
        <div class="inner">
            <p class="item-text-hover"><?= '1' ?></p>
            <img src="<?= $baseUrl . '/images/item-4.png' ?>" alt="item-3">
        </div>
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-3">
        <div class="inner">
            <p class="item-text-hover"><?= '1' ?></p>
            <img src="<?= $baseUrl . '/images/item-6.png' ?>" alt="item-6">
        </div>
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-4">
        <div class="inner">
            <p class="item-text-hover"><?= '1' ?></p>
            <img src="<?= $baseUrl . '/images/item-5.png' ?>" alt="item-4">
        </div>
        </div><?php endif; ?>
    <div class="item center-icon">
        <div class="inner">
            <p class="title-center-icon-1"><?= $model->area_size ?></p>
            <p class="title-center-icon-2"><?= trans('words', 'Meters') ?></p>
        </div>
    </div>
    <?php if ($model->hasField('')): ?>
        <div class="item item-5">
        <div class="inner">
            <p class="item-text-hover"><?= '1' ?></p>
            <img src="<?= $baseUrl . '/images/item-2.png' ?>" alt="item-2">
        </div>
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-6">
        <div class="inner">
            <p class="item-text-hover"><?= '1' ?></p>
            <img src="<?= $baseUrl . '/images/item-9.png' ?>" alt="item-9">
        </div>
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-7">
        <div class="inner">
            <p class="item-text-hover"><?= '1' ?></p>
            <img src="<?= $baseUrl . '/images/item-3.png' ?>" alt="item-3">
        </div>
        </div><?php endif; ?>
    <?php if ($model->hasField('')): ?>
        <div class="item item-8">
        <div class="inner">
            <p class="item-text-hover"><?= '1' ?></p>
            <img src="<?= $baseUrl . '/images/item-10.png' ?>" alt="item-10">
        </div>
        </div><?php endif; ?>
<?php endif; ?>