<?php
/** @var $this View */

/** @var $block Contact */

use app\controllers\BlockController;
use app\models\blocks\Banner;
use app\models\blocks\Contact;
use app\models\blocks\Image;
use yii\helpers\Html;
use yii\web\View;

if (!is_array($block->image)):
    $path = alias('@webroot') . DIRECTORY_SEPARATOR . BlockController::$imgDir . DIRECTORY_SEPARATOR . $block->image;
    $url = request()->getBaseUrl() . '/' . BlockController::$imgDir . '/' . $block->image;
    if ($block->image && is_file($path)):
        ?>
        <section class="slide-4" id="contact-section">
            <div class="picture-slide-1">
                <img src="<?= $url ?>" alt="<?= Html::encode($block->name) ?>">
            </div>
        </section>
    <?php
    endif;
endif;