<?php
/** @var $this View */
/** @var $block NearbyAccess */

/** @var $project Project */

use app\models\blocks\Banner;
use app\models\blocks\NearbyAccess;
use app\models\Project;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;

?>
<section class="slide-3" id="nearby-section">
    <div class="container-fluid">
        <div class="row">
            <div class="slide-title">
                <div class="title-right">
                    <p class="slide"><?= trans('words', '<strong>Building </strong> access<br>Near you') ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <?php foreach (NearbyAccess::$fields as $field): ?>
                <div class="col-lg-4 building-access">
                    <?php if ($block->{$field . '_link'}): ?><a href="<?= $block->{$field . '_link'} ?>"><?php endif; ?>
                        <div class="row">
                            <div class="col-lg-2 thumb">
                                <img class="img-building-access"
                                     src="<?= $baseUrl . '/images/' . NearbyAccess::$iconsName[$field] ?>"
                                     alt="<?= $field ?>">
                            </div>
                            <div class="col-lg-10 right">
                                <h3 class="title-building-access"><?= $block->getAttributeLabel($field) ?></h3>
                                <p class="desc-building-access"><?= $block->getDistance($field); ?></p>
                            </div>
                        </div>
                    <?php if ($block->{$field . '_link'}): ?></a><?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>