<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;

$apartmentCounts = isset($availableApartments) ? count($availableApartments) : 0;

?>

<section class="main-text">
    <div class="slide-title">
        <div class="title-left">
            <!--<img src="<?//= $baseUrl ?>/images/apartment-icon-w.png" alt="apartment-icon">-->
            <div class="text">
                <h2 class="slide"><strong><?= Html::encode($this->title) ?></strong> Rezvan</strong></h2>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="main-section-page">
                    <div class="txt-post-page-test">
                        <!--                        <code>--><? //= __FILE__ ?><!--</code>-->

                        <p><strong>Where does it come from?</strong></p>
                        <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of
                            classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a
                            Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure
                            Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the
                            word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from
                            sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and
                            Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very
                            popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit
                            amet..", comes from a line in section 1.10.32.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="order-post">
    <div class="container-fluid">
        <div class="row">
            <div class="title-order-post">
                <h2 id="txt-order-post">
                    <strong>PROJECTS</strong>
                </h2>
            </div>
            <div id="order-post" class="carousel slide col-lg-12" data-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    for ($i = 0; $i < $apartmentCounts; $i = $i + 3): ?>
                        <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                            <div class="posts">
                                <div class="row">
                                    <?php
                                    if (!isset($availableApartments[$i])) break;
                                    $apartment = $availableApartments[$i];
                                    ?>
                                    <div class="grid col-lg-4">
                                        <div class="img">
                                            <img src="<?= $apartment->getModelImage() ?>"
                                                 alt="<?= Html::encode($apartment->name) ?>">
                                        </div>
                                    </div>

                                    <?php if (!isset($availableApartments[$i + 1])) break;
                                    $apartment = $availableApartments[$i + 1];
                                    ?>
                                    <div class="grid col-lg-4">
                                        <div class="img">
                                            <img src="<?= $apartment->getModelImage() ?>"
                                                 alt="<?= Html::encode($apartment->name) ?>">
                                        </div>
                                    </div>

                                    <?php if (!isset($availableApartments[$i + 2])) break;
                                    $apartment = $availableApartments[$i + 2];
                                    ?>
                                    <div class="grid col-lg-4">
                                        <div class="img">
                                            <img src="<?= $apartment->getModelImage() ?>"
                                                 alt="<?= Html::encode($apartment->name) ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endfor; ?>

                    <a class="carousel-control-prev" href="#order-post" data-slide="prev">
                        <i class="fas fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#order-post" data-slide="next">
                        <i class="fas fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

