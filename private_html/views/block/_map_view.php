<?php
/** @var $this View */

/** @var $block Map */

use app\controllers\BlockController;
use app\models\blocks\Banner;
use app\models\blocks\Map;
use yii\helpers\Html;
use yii\web\View;

$url = request()->getBaseUrl() . '/' . BlockController::$imgDir . '/' . $block->image;
?>
<section class="slide-2" id="map-section">
    <div class="picture-slide-4">
        <a target="_blank" rel="nofollow" href="<?= $block->location_link ?>"><img src="<?= $url ?>" alt="<?= $block->name ?>"></a>
    </div>
</section>