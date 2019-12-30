<?php
/** @var $this View */

/** @var $block Video */

use app\controllers\BlockController;
use app\models\blocks\Banner;
use app\models\blocks\Video;
use yii\helpers\Html;
use yii\web\View;

?>
<section class="slide-2 video-slide" id="video-section-<?= $block->id ?>">
    <div class="picture-slide-1"><?= $block->getContent() ?></div>
</section>
