<?php
/** @var Apartment $apartment */
/** @var OtherConstruction $construction */
/** @var Investment $investment */
/** @var Slide $slides */
/** @var Service $service */

use app\models\Slide;
use app\models\projects\Apartment;
use app\models\projects\Investment;
use app\models\projects\OtherConstruction;
use app\models\Service;
use yii\helpers\Html;
use yii\helpers\Url;

$baseUrl = $this->theme->baseUrl;

$availableApartmentsCounts = isset($availableApartments) ? count($availableApartments) : 0;
$availableInvestmentsCounts = isset($availableInvestments) ? count($availableInvestments) : 0;
$availableConstructionsCounts = isset($availableConstructions) ? count($availableConstructions) : 0;
$serviceCounts = isset($services) ? count($services) : null;
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

<?php if (isset($availableApartments) && $availableApartmentsCounts > 0): ?>
    <section class="slide-1">
        <div class="container-fluid">
            <div class="row">
                <div class="slide-title">
                    <div class="title-left">
                        <img src="<?= alias('@web/themes/frontend/images/apartment-icon.png') ?>"
                             alt="apartment-icon">
                        <h2 class="slide"><?= trans('words', '<strong>available </strong> apartment') ?></h2>
                    </div>
                    <div class="title-right">
                        <p class="slide">
                            <span class="projects">
                                <?= trans('words', '{count} projects', ['count' => $apartmentCounts]) ?> /
                            </span>
                            <span class="available-project"><?= trans('words', 'available<br>project') ?></span>
                            <span class="num"><?= $availableApartmentsCounts ?></span>
                        </p>
                    </div>
                </div>

                <div id="slide-1" class="carousel slide col-lg-12 col-md-12  col-sm-12" data-ride="carousel">
                    <!-- Indicators -->

                    <ul class="carousel-indicators">
                        <?php $pageNumber = 1;

                        for ($i = 0; $i < $availableApartmentsCounts; $i++): ?>
                            <?php if ($availableApartmentsCounts / 4 >= 1 && $i % 4 == 0): ?>
                                <li data-target="#slide-1" data-slide-to="<?php echo $pageNumber - 1 ?>"
                                    class="<?= $i / 4 == 1 && $i % 4 == 0 ? 'active' : '' ?>"><span
                                            class="indicators"><?= trans('words', 'page') ?><?php echo $pageNumber++ ?></span>
                                </li>
                            <?php endif; endfor; ?>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < $availableApartmentsCounts; $i = $i + 5): ?>
                            <?php $apartment = $availableApartments[$i];
                            if (!isset($availableApartments[$i]))
                                break;
                            ?>
                            <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                                <div class="posts">
                                    <div class="row">
                                        <div class="grid first-post col-lg-6 col-md-6  col-sm-12 col-xs-12">
                                            <a href="<?= Url::to(['/apartment/show/', 'id' => $apartment->id]) ?>"
                                               title="<?= Html::encode($apartment->getName()) ?>">
                                                <img src="<?= $apartment->getModelImage() ?>"
                                                     alt="<?= Html::encode($apartment->getName()) ?>">
                                                <?php if ($apartment->free_count == 0): ?><span
                                                        class="sold-icon">SOLD!</span><?php endif; ?>
                                                <div class="top-title">
                                                    <h2 class="item-title"><?= Html::encode($apartment->getName()) ?></h2>
                                                    <span class="first-title"><?= Html::encode($apartment->getSubtitleStr()) ?></span>
                                                    <span class="description"><?= Html::encode($apartment->getLocationStr()) ?></span>
                                                </div>
                                                <div class="overly">
                                                    <?= $this->render('//site/_project_side', ['model' => $apartment]) ?>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-6 col-md-6  col-sm-12 col-xs-12 right-post-slider">
                                            <div class="row">
                                                <?php for ($j = $i + 1; $j <= $i + 4; $j++): ?>
                                                    <?php if (!isset($availableApartments[$j]))
                                                        break;
                                                    $apartment = $availableApartments[$j]; ?>
                                                    <div class="grid little-post col-lg-6 col-md-6  col-sm-12 col-xs-12">
                                                        <a href="<?= Url::to(['/apartment/show/', 'id' => $apartment->id]) ?>"
                                                           title="<?= Html::encode($apartment->getName()) ?>">
                                                            <img src="<?= $apartment->getModelImage() ?>"
                                                                 alt="<?= Html::encode($apartment->getName()) ?>">
                                                            <h2 class="item-title">
                                                                <?= Html::encode($apartment->getName()) ?></h2>
                                                            <span class="description"><?= Html::encode($apartment->getLocationStr()) ?><?= $apartment->getLocationTwoStr() ? ' / ' : '' ?></span>
                                                            <span class="description-2"><?= $apartment->getLocationTwoStr() ?: '' ?></span>
                                                        </a>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>

                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#slide-1" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#slide-1" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                    <div class="button-more">
                        <a href="<?= Url::to(['/apartment/list']) ?>" title="<?= trans('words', 'View More') ?>">
                            <button type="button"
                                    class="btn btn-primary section-button"><?= trans('words', 'View More') ?></button>
                        </a>
                    </div>
                </div>
            </div>
    </section>
<?php endif; ?>

<?php if (isset($availableInvestments) && $availableInvestmentsCounts > 0): ?>
    <section class="slide-2">
        <div class="container-fluid">
            <div class="row">
                <div class="slide-title">
                    <div class="title-left">
                        <img src="<?= alias('@web/themes/frontend/images/investment.png') ?>"
                             alt="apartment-icon">
                        <h2 class="slide"><?= trans('words', '<strong>available </strong> investment') ?></h2>
                    </div>
                    <div class="title-right">
                        <p class="slide">
                            <span class="projects">
                                <?= trans('words', '{count} projects', ['count' => $investmentCounts]) ?> /
                            </span>
                            <span class="available-project"><?= trans('words', 'available<br>project') ?></span>
                            <span class="num"><?= $availableInvestmentsCounts ?></span>
                        </p>
                    </div>
                </div>
                <div id="slide-2" class="carousel slide col-lg-12 col-md-12  col-sm-12 col-xs-12" data-ride="carousel">
                    <!-- Indicators -->
                    <ul class="carousel-indicators">
                        <?php $pageNumber = 1;

                        for ($i = 0; $i < $availableInvestmentsCounts; $i++): ?>
                            <?php if ($availableInvestmentsCounts / 5 > 1 && $i % 5 == 0): ?>
                                <li data-target="#slide-2" data-slide-to="<?php echo $pageNumber - 1 ?>"
                                    class="<?= $i / 4 == 1 && $i % 4 == 0 ? 'active' : '' ?>"><span
                                            class="indicators"><?= trans('words', 'page') ?><?php echo $pageNumber++ ?></span>
                                </li>
                            <?php endif; endfor; ?>
                    </ul>

                    <!-- The slideshow -->
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < $availableInvestmentsCounts; $i = $i + 5): ?>
                            <?php $investment = $availableInvestments[$i];
                            if (!isset($availableInvestments[$i]))
                                break; ?>
                            <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                                <div class="posts">
                                    <div class="row">
                                        <div class="grid first-post col-lg-6 col-md-6  col-sm-12 col-xs-12 order-12">
                                            <a href="<?= $investment->getUrl() ?>"
                                               title="<?= Html::encode($investment->getName()) ?>">
                                                <img src="<?= $investment->getModelImage() ?>"
                                                     alt="<?= Html::encode($investment->getName()) ?>">
                                                <?php if ($investment->free_count == 0): ?><span
                                                        class="sold-icon">SOLD!</span><?php endif; ?>
                                                <div class="top-title">
                                                    <h2 class="item-title"><?= Html::encode($investment->getName()) ?></h2>
                                                    <span class="first-title"><?= Html::encode($investment->getSubtitleStr()) ?></span>
                                                    <span class="description"><?= Html::encode($investment->getLocationStr()) ?></span>
                                                </div>
                                                <div class="overly">
                                                    <?= $this->render('//site/_project_side', ['model' => $investment]) ?>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-lg-6 col-md-6  col-sm-12 col-xs-12 left-post-slider">
                                            <div class="row">
                                                <?php for ($j = $i + 1; $j <= $i + 4; $j++): ?>
                                                    <?php if (!isset($availableInvestments[$j]))
                                                        break;
                                                    $investment = $availableInvestments[$j]; ?>
                                                    <div class="grid little-post col-lg-6 col-md-6  col-sm-12 col-xs-12">
                                                        <a href="<?= $investment->getUrl() ?>"
                                                           title="<?= Html::encode($investment->getName()) ?>">
                                                            <img src="<?= $investment->getModelImage() ?>"
                                                                 alt="<?= Html::encode($investment->getName()) ?>">
                                                            <h2 class="item-title">
                                                                <?= Html::encode($investment->getName()) ?></h2>
                                                            <span class="description"><?= Html::encode($investment->getLocationStr()) ?><?= $investment->getLocationTwoStr() ? ' / ' : '' ?></span>
                                                            <span class="description-2"><?= $investment->getLocationTwoStr() ?: '' ?></span>
                                                        </a>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>

                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#slide-1" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#slide-1" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>

                    </div>
                    <?php /* ?>
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i < $availableInvestmentsCounts; $i = $i + 5): ?>
                            <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                                <div class="posts">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6  col-sm-12 col-xs-12 left-post-slider">
                                            <div class="row">
                                                <?php for ($j = $i; $j < $i + 4; $j++): ?>
                                                    <?php
                                                    if (!isset($availableInvestments[$j])) break;
                                                    $investment = $availableInvestments[$j];
                                                    ?>
                                                    <div class="grid little-post col-lg-6 col-md-6  col-sm-12 col-xs-12">
                                                        <img src="<?= $investment->getModelImage() ?>"
                                                             alt="<?= $investment->getName() ?>">
                                                        <?php if ($investment->free_count == 0): ?><span
                                                                class="sold-icon">SOLD!</span><?php endif; ?>
                                                        <a href="<?= $investment->getUrl(); ?>">
                                                            <h2 class="item-title"><?= $investment->getName() ?></h2>
                                                        </a>
                                                        <span class="description"><?= $investment->getLocationStr() ?><?= $investment->getLocationTwoStr() ? ' / ' : '' ?></span>
                                                        <span class="description-2"><?= $investment->getLocationTwoStr() ?></span>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <?php
                                        if (!isset($availableInvestments[$i + 4])) break;
                                        $investment = $availableInvestments[$i + 4];
                                        ?>
                                        <div class="grid first-post col-lg-6 col-md-6  col-sm-12 col-xs-12">
                                            <img src="<?= $investment->getModelImage() ?>"
                                                 alt="<?= $investment->getName() ?>">
                                            <a href="<?= Url::to(['/investment/show/', 'id' => $investment->id]) ?>">
                                                <h2 class="item-title"><?= $investment->getName() ?></h2>
                                            </a>
                                            <span class="description"><?= $investment->getLocationStr() ?> / </span>
                                            <div class="overly">
                                                <?= $this->render('//site/_project_side', ['model' => $investment]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>

                        <!-- Left and right controls -->
                        <a class="carousel-control-prev" href="#slide-2" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#slide-2" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>

                    </div>
<?php */ ?>
                    <div class="button-more">
                        <a href="<?= Url::to(['/investment/list']) ?>" title="<?= trans('words', 'View More') ?>">
                            <button type="button"
                                    class="btn btn-primary section-button"><?= trans('words', 'View More') ?></button>
                        </a>
                    </div>
                </div>
            </div>
    </section>
<?php endif; ?>

<?php if (isset($services) && $serviceCounts > 0): ?>
    <section class="slide-3">
        <div class="container-fluid">
            <div class="row">
                <div class="slide-title">
                    <div class="title-left">
                        <img src="<?= $baseUrl . '/images/services.png' ?>" alt="services-icon">
                        <h2 class="slide">
                            <strong><?= trans('words', 'available') ?></strong> <?= trans('words', 'services') ?></h2>
                    </div>
                </div>
                <div id="slide-3" class="carousel slide w-100" data-ride="carousel">
                    <ul class="carousel-indicators">
                        <?php $pageNumber = 1;

                        for ($i = 0; $i < $serviceCounts; $i++): ?>
                            <?php if ($serviceCounts / 4 > 1 && $i % 4 == 0): ?>
                                <li data-target="#slide-3" data-slide-to="<?php echo $pageNumber - 1 ?>"
                                    class="<?= $i / 4 == 1 && $i % 4 == 0 ? 'active' : '' ?>"><span
                                            class="indicators"><?= trans('words', 'page') ?><?php echo $pageNumber++ ?></span>
                                </li>
                            <?php endif; endfor; ?>

                    </ul>
                    <div class="carousel-inner row w-100 mx-auto" role="listbox">
                        <?php for ($i = 0; $i < $serviceCounts; $i = $i + 3): ?>
                            <div class="carousel-item col-lg-12 col-md-12 col-sm-12 col-xs-12 <?= $i == 0 ? 'active' : '' ?>">
                                <div class="row">
                                    <?php for ($j = $i; $j < $i + 3; $j++): ?>
                                        <?php
                                        if (!isset($services[$j])) break;
                                        $service = $services[$j];
                                        ?>
                                        <div class="col-sm-12 col-md-4 col-lg-4">
                                            <a href="<?= $service->getUrl() ?>"
                                               title="<?= Html::encode($service->getName()) ?>">
                                                <h2 class="item-title"><?= $service->getName() ?></h2>
                                            </a>
                                            <p class="description"><?= Html::encode($service->getDescriptionStr()) ?></p>
                                            <a href="<?= $service->getUrl() ?>"
                                               title="<?= Html::encode($service->getName()) ?>">
                                                <button type="button" class="btn btn-primary slider-button">
                                                    <?= trans('words', 'View More') ?>
                                                </button>
                                            </a>
                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <a class="carousel-control-prev" href="#slide-3" role="button" data-slide="prev">
                        <i class="fal fa-chevron-left"></i>
                        <span class="sr-only"><?= trans('words', 'Previous') ?></span>
                    </a>
                    <a class="carousel-control-next" href="#slide-3" role="button" data-slide="next">
                        <i class="fal fa-chevron-right"></i>
                        <span class="sr-only"><?= trans('words', 'Next') ?></span>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php if (isset($availableConstructions) && $availableConstructionsCounts > 0): ?>
    <section class="slide-4">
        <div class="container-fluid">
            <div class="row">
                <div class="slide-title">
                    <div class="title-left">
                        <img src="<?= $baseUrl . '/images/investment.png' ?>" alt="investment-icon">
                        <h2 class="slide"><?= trans('words', '<strong>other</strong> construction') ?></h2>
                    </div>
                </div>

                <div id="slide-4" class="carousel slide col-lg-12 col-md-12  col-sm-12 col-xs-12" data-ride="carousel">
                    <ul class="carousel-indicators">
                        <?php $pageNumber = 1;

                        for ($i = 0; $i < $availableConstructionsCounts; $i++): ?>
                            <?php if ($availableConstructionsCounts / 4 > 1 && $i % 4 == 0): ?>
                                <li data-target="#slide-4" data-slide-to="<?php echo $pageNumber - 1 ?>"
                                    class="<?= $i / 4 == 1 && $i % 4 == 0 ? 'active' : '' ?>"><span
                                            class="indicators"><?= trans('words', 'page') ?><?php echo $pageNumber++ ?></span>
                                </li>
                            <?php endif; endfor; ?>
                    </ul>
                    <div class="carousel-inner">
                        <?php
                        for ($i = 0; $i < $availableConstructionsCounts; $i = $i + 4): ?>
                            <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                                <div class="posts">
                                    <div class="row">
                                        <?php for ($j = $i; $j < $i + 4; $j++): ?>
                                            <?php
                                            if (!isset($availableConstructions[$j])) break;
                                            $construction = $availableConstructions[$j];
                                            ?>
                                            <div class="grid col-lg-3 col-md-6  col-sm-12 col-xs-12">
                                                <div class="img"><img src="<?= $construction->getModelImage() ?>"
                                                                      alt="<?= Html::encode($construction->getName()) ?>">
                                                </div>
                                                <div class="post-meta">
                                                    <a href="<?= $construction->getUrl() ?>"
                                                       title="<?= Html::encode($construction->getName()) ?>">
                                                        <h2 class="item-title"><?= Html::encode($construction->getName()) ?></h2>
                                                    </a>
                                                    <span class="author"><?= Html::encode($construction->getLocationStr()) ?></span>
                                                    <span class="description"><?= Html::encode($construction->getLocationStr()) ?></span>
                                                    <a href="<?= $construction->getUrl() ?>">
                                                        <button type="button"
                                                                class="btn btn-primary"><?= trans('words', 'View More') ?></button>
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>

                        <a class="carousel-control-prev" href="#slide-4" data-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </a>
                        <a class="carousel-control-next" href="#slide-4" data-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </a>
                    </div>
                    <div class="button-more">
                        <a href="<?= Url::to(['/construction/list']) ?>" title="<?= trans('words', 'View More') ?>">
                            <button type="button"
                                    class="btn btn-primary section-button"><?= trans('words', 'View More') ?></button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
