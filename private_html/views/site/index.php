<?php
/** @var Apartment $apartment */
/** @var OtherConstruction $construction */
/** @var Investment $investment */
/** @var Slide $slides */
/** @var Service $service */

use app\models\Slide;
use app\models\Service;
use yii\helpers\Html;
use yii\helpers\Url;

$baseUrl = $this->theme->baseUrl;
?>

<?php if ($count = count($slides)):?>
    <section class="slider carousel" id="main-slider" data-ride="carousel">
        <ul class="carousel-indicators"><?php
            $pageNumber = 1;
            for ($i = 0; $i < $count; $i++): ?>
                <li data-target="#main-slider" data-slide-to="<?php echo $pageNumber - 1 ?>"
                    class="<?= $i == 0 ? 'active' : '' ?>"><span
                            class="indicators"><?= trans('words', 'page') ?><?php echo $pageNumber++ ?></span>
                </li>
            <?php endfor; ?></ul>
        <div class="carousel-inner" style="padding: 0">
            <?php
            $i = 0;
            foreach ($slides as $item):
                $path = alias('@webroot') . DIRECTORY_SEPARATOR . 'uploads/slide' . DIRECTORY_SEPARATOR . $item->image;
                $url = request()->getBaseUrl() . '/uploads/slide/' . $item->image;
                if (is_file($path)):
                    ?>
                    <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                        <div class="picture-slide-1">
                            <img src="<?= $url ?>" alt="<?= Html::encode($item->name) ?>">
                        </div>
                    </div>
                    <?php
                    $i++;
                endif;
            endforeach; ?>
        </div>
        <a class="carousel-control-prev" href="#main-slider" data-slide="prev">
            <i class="fas fa-angle-left"></i>
        </a>
        <a class="carousel-control-next" href="#main-slider" data-slide="next">
            <i class="fas fa-angle-right"></i>
        </a>
    </section>
<?php else: ?>
<section class="slider">
    <div class="container">
        <div class="row"></div>
    </div>
</section>
<?php endif;?>
