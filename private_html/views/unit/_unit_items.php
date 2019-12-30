<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */

$baseUrl = $this->theme->baseUrl;
?>
<?php if (isset($sold) && $sold): ?>
    <div class="item item-1">
        <p class="item-1"><?= $model->getName() ?></p>
        <p class="item-1"><?= $model->area_size ?> <?= trans('words', 'Meters') ?></p>
    </div>
    <div class="item item-2">
        <img src="<?= $baseUrl . '/images/item-2-l.png' ?>" alt="item-2">
        <span class="item-2"><?= $model->getFloorNumberStr() ?></span>
    </div>
    <div class="item item-3">
        <img src="<?= $baseUrl . '/images/item-3-l.png' ?>" alt="item-3">
        <span class="item-2"><?= $model->getBedRoomStr(true) ?></span>
    </div>
    <div class="item item-4">
        <img src="<?= $baseUrl . '/images/item-4-l.png' ?>" alt="item-4">
        <span class="item-2"><?= $model->getAirConditionerStr(true) ?></span>
    </div>
    <div class="item item-5">
        <img src="<?= $baseUrl . '/images/item-5-l.png' ?>" alt="item-5">
        <span class="item-2"><?= $model->getWcStr(true) ?></span>
    </div>
    <div class="item item-6">
        <img src="<?= $baseUrl . '/images/item-6-l.png' ?>" alt="item-6">
        <span class="item-2"><?= $model->getBathRoomStr(true) ?></span>
    </div>
    <div class="item item-7">
        <img src="<?= $baseUrl . '/images/item-7-l.png' ?>" alt="item-7">
        <span class="item-2"><?= $model->getParkingStr(true) ?></span>
    </div>
    <div class="item item-8">
        <img src="<?= $baseUrl . '/images/item-8-l.png' ?>" alt="item-8">
        <span class="item-2"><?= $model->getRadiatorStr(true) ?></span>
    </div>

<?php else: ?>
    <div class="item item-1">
        <p class="item-1"><?= $model->getName() ?></p>
        <p class="item-1"><?= $model->area_size ?> <?= trans('words', 'Meters') ?></p>
    </div>
    <div class="item item-2">
        <img src="<?= $baseUrl . '/images/item-2.png' ?>" alt="item-2">
        <span class="item-2"><?= $model->getFloorNumberStr() ?></span>
    </div>
    <div class="item item-3">
        <img src="<?= $baseUrl . '/images/item-3.png' ?>" alt="item-3">
        <span class="item-2"><?= $model->getBedRoomStr(true) ?></span>
    </div>
    <div class="item item-4">
        <img src="<?= $baseUrl . '/images/item-4.png' ?>" alt="item-4">
        <span class="item-2"><?= $model->getAirConditionerStr(true) ?></span>
    </div>
    <div class="item item-5">
        <img src="<?= $baseUrl . '/images/item-5.png' ?>" alt="item-5">
        <span class="item-2"><?= $model->getWcStr(true) ?></span>
    </div>
    <div class="item item-6">
        <img src="<?= $baseUrl . '/images/item-6.png' ?>" alt="item-6">
        <span class="item-2"><?= $model->getBathRoomStr(true) ?></span>
    </div>
    <div class="item item-7">
        <img src="<?= $baseUrl . '/images/item-7.png' ?>" alt="item-7">
        <span class="item-2"><?= $model->getParkingStr(true) ?></span>
    </div>
    <div class="item item-8">
        <img src="<?= $baseUrl . '/images/item-8.png' ?>" alt="item-8">
        <span class="item-2"><?= $model->getRadiatorStr(true) ?></span>
    </div>
<?php endif;