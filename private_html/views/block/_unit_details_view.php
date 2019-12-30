<?php
/** @var $this View */

/** @var $block UnitDetails */

use app\models\blocks\UnitDetails;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;
$unit = $block->getUnit();
?>
<section class="slide-4" id="unit-section">
    <div class="content">
        <div class="container-fluid">
            <div class="row available">
                <div class="available-left-title col-lg-3">
                    <div class="title-left">
                        <p class="slide"><?= trans('words','<strong>Current status</strong><br> of the UNIT {unit_number}',['unit_number' => $unit->unit_number]) ?></p>
                    </div>
                    <img src="<?= $baseUrl .'/images/door-icon.png' ?>" alt="door">
                    <div class="title-unit">
                        <div class="title-unit">
                            <p><?= trans('words', '<span class="green"><strong>unit {unit_number}</strong></span> <strong>available</strong>', ['unit_number' => $unit->unit_number]) ?></p>
                            <p><?= trans('words', 'from {all_units} units / ON FLOOR {floor}', ['all_units' => $unit->number_of_units,'floor'=>$unit->floor_number]) ?> </p>
                        </div>
                    </div>
                    <div class="desc-unit">
                        <p><?= $unit->getDescriptionSrc() ?></p>
                    </div>
                </div>
                <div class="available-right-title col-lg-9 col-md-12 col-sm-12 ">
                    <div class="item-inner">
                        <div class="items">
                            <?= $this->render('//unit/_unit_items', ['model' => $unit]) ?>
                        </div>
                        <div class="item-list">
                            <?= $this->render('//unit/_unit_details', ['model' => $unit]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>