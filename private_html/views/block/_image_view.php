<?php
/** @var $this View */

/** @var $block Image */

use app\controllers\BlockController;
use app\models\blocks\Banner;
use app\models\blocks\Image;
use yii\helpers\Html;
use yii\web\View;

$link = $block->link ?" href='{$block->link}' target='_blank'": false;

if (!is_array($block->image)):
    $path = alias('@webroot') . DIRECTORY_SEPARATOR . BlockController::$imgDir . DIRECTORY_SEPARATOR . $block->image;
    $url = request()->getBaseUrl() . '/' . BlockController::$imgDir . '/' . $block->image;
    if ($block->image && is_file($path)):
        ?>
        <section class="slide-2">
            <div class="picture-slide-1">
                <a<?= $link ?>>
                    <img src="<?= $url ?>" alt="<?= Html::encode($block->name) ?>">
                </a>
            </div>
        </section>
    <?php
    endif;
else:
    if ($block->image):
        ?>
        <section class="slide-2">
            <?php foreach ($block->image as $item):
                $path = alias('@webroot') . DIRECTORY_SEPARATOR . BlockController::$imgDir . DIRECTORY_SEPARATOR . $item;
                $url = request()->getBaseUrl() . '/' . BlockController::$imgDir . '/' . $item;
                if (is_file($path)):
                    ?>
                    <div class="picture-slide-1">
                        <a<?= $link ?>>
                            <img src="<?= $url ?>" alt="<?= Html::encode($block->name) ?>">
                        </a>
                    </div>
                <?php
                endif;
            endforeach; ?>
        </section>
    <?php
    endif;
endif;