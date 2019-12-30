<?php
/** @var $this View */

/** @var $block Gallery */

use app\controllers\BlockController;
use app\models\blocks\Banner;
use app\models\blocks\Gallery;
use app\models\blocks\Image;
use app\models\Item;
use yii\helpers\Html;
use yii\web\View;

if ($block->image):
    $count = count($block->image);
    ?>
    <section class="slide-2 carousel slide" id="gallery-<?= $block->id ?>" data-ride="carousel">
        <ul class="carousel-indicators"><?php
            $pageNumber = 1;
            for ($i = 0; $i < $count; $i++): ?>
                <li data-target="#gallery-<?= $block->id ?>" data-slide-to="<?php echo $pageNumber - 1 ?>"
                    class="<?= $i == 0 ? 'active' : '' ?>"><span
                            class="indicators"><?= trans('words', 'page') ?><?php echo $pageNumber++ ?></span>
                </li>
            <?php endfor; ?></ul>
        <div class="carousel-inner" style="padding: 0">
            <?php
            $i = 0;
            foreach ($block->image as $item):
                $path = alias('@webroot') . DIRECTORY_SEPARATOR . BlockController::$imgDir . DIRECTORY_SEPARATOR . $item;
                $url = request()->getBaseUrl() . '/' . BlockController::$imgDir . '/' . $item;
                if (is_file($path)):
                    ?>
                    <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                        <div class="picture-slide-1">
                            <img src="<?= $url ?>" alt="<?= Html::encode($block->name) ?>">
                        </div>
                    </div>
                    <?php
                    $i++;
                endif;
            endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#gallery-<?= $block->id ?>" data-slide="prev">
            <i class="fas fa-angle-left"></i>
        </a>
        <a class="carousel-control-next" href="#gallery-<?= $block->id ?>" data-slide="next">
            <i class="fas fa-angle-right"></i>
        </a>
    </section>
<?php
endif;