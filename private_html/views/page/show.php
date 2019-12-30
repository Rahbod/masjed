<?php

/* @var $this yii\web\View */
/* @var $model Page */
/* @var $project Project */

use app\models\Page;
use app\models\Project;
use yii\helpers\Html;

$this->title = strip_tags($model->getName());

$baseUrl = $this->theme->baseUrl;
$projectCounts = isset($availableProjects) ? count($availableProjects) : 0;
?>
<section class="main-text">
    <div class="slide-title">
        <div class="title-left">
            <div class="text">
                <h2 class="slide"><strong><?= $this->title ?></strong></h2>
            </div>
        </div>
    </div>
    <div class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="main-section-page">
                    <div class="txt-post-page-test">
                        <p><strong><?= $model->getName() ?></strong></p>
                        <img src="<?= $model->getModelImage() ?>" alt="">
                        <p><?= Html::decode($model->getBodyStr()) ?></p>
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
                    <strong><?= trans('words', 'projects') ?></strong>
                </h2>
            </div>
            <div id="order-post" class="carousel slide col-lg-12" data-ride="carousel">
                <div class="carousel-inner">
                    <?php for ($i = 0; $i < $projectCounts; $i = $i + 4): ?>
                        <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                            <div class="posts">
                                <div class="row">
                                    <?php for ($j = $i; $j < $i+ 4; $j++):
                                        if (!isset($availableProjects[$j]))
                                            break;
                                        $project = $availableProjects[$j]; ?>
                                        <div class="grid little-post col-lg-3 col-md-6  col-sm-12 col-xs-12">
                                            <a href="<?= $project->getUrl() ?>">
                                                <img src="<?= $project->getModelImage() ?>"
                                                     alt="<?= $project->getName() ?>">
                                                <h2 class="item-title"><?= $project->getName() ?></h2>
                                                <span class="description"><?= $project->getLocationStr() ?><?= $project->getLocationTwoStr()?' / ':'' ?></span>
                                                <span class="description-2"><?= $project->getLocationTwoStr() ?></span>
                                            </a>
                                        </div>
                                    <?php endfor; ?>
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
