<?php

/* @var $this yii\web\View */
/* @var $availableOtherConstructions OtherConstruction[] */

/* @var $projects OtherConstruction[] */

use app\models\projects\OtherConstruction;
use yii\helpers\Html;
use yii\helpers\Url;

$baseUrl = $this->theme->baseUrl;
$constructionCounts = isset($projects) ? count($projects) : 0;

?>

<?php if (isset($projects)): ?>
    <section class="full-slide">
        <div class="container-fluid">
            <div class="row">
                <div class="slide-title">
                    <div class="title-left">
                        <img src="<?= $baseUrl ?>/images/apartment-icon-w.png" alt="construction-icon">
                        <div class="text">
                            <h2 class="slide"><?= trans('words', '<strong>available </strong> construction') ?></h2>
                        </div>
                    </div>
                    <div class="title-right">
                        <p class="slide">
                             <span class="projects">
                                <?= trans('words', '{count} projects', ['count' => $constructionCounts]) ?> /
                            </span>
                            <span class="available-project"><?= trans('words', 'available<br>project') ?></span>
                            <span class="num"><?= $availableOtherConstructions ?></span>
                        </p>
                    </div>
                </div>
                <div class="container-fluid project-list">
                    <div class="row">
                        <?php if (isset($projects[0])): ?>
                            <div class="grid first-post col-lg-6">
                                <a title="<?= Html::encode($projects[0]->getName()) ?>"
                                   href="<?= $projects[0]->getUrl() ?>">
                                    <img src="<?= $projects[0]->getModelImage() ?>"
                                         alt="<?= Html::encode($projects[0]->getName()) ?>">
                                    <div class="top-title">
                                        <h2 class="item-title"><?= Html::encode($projects[0]->getName()) ?></h2>
                                        <span class="first-title"><?= $projects[0]->getSubtitleStr() ?></span>
                                        <span class="description"><?= $projects[0]->getLocationTwoStr() ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <div class="col-lg-6 right-post-slider">
                            <div class="row">
                                <?php foreach ($projects as $key => $project):
                                    if ($key && $key > 0 && $key < 5) : ?>
                                        <div class="grid col-lg-6">
                                            <a title="<?= Html::encode($project->getName()) ?>"
                                               href="<?= $project->getUrl() ?>">
                                                <img src="<?= $project->getModelImage() ?>"
                                                     alt="<?= Html::encode($project->getName()) ?> ">
                                                <h2 class="item-title"><?= Html::encode($project->getName()) ?></h2>
                                                <span class="description"><?= $project->getSubtitleStr() ?><?= $project->getLocationTwoStr() ? ' / ' : '' ?></span>
                                                <span class="description-2"><?= $project->getLocationTwoStr() ?></span>
                                            </a>
                                        </div>
                                    <?php endif;
                                endforeach; ?>
                            </div>
                        </div>

                        <?php foreach ($projects as $key => $project):
                            if ($key && $key > 4) : ?>
                                <div class="grid col-lg-3">
                                    <a title="<?= Html::encode($project->getName()) ?>"
                                       href="<?= $project->getUrl() ?>">
                                        <img src="<?= $project->getModelImage() ?>"
                                             alt="<?= Html::encode($project->getName()) ?> ">
                                        <h2 class="item-title"><?= Html::encode($project->getName()) ?></h2>
                                        <span class="description"><?= $project->getLocationStr() ?></span>
                                        <span class="description-2"><?= $project->getLocationTwoStr() ?></span>
                                    </a>
                                </div>
                            <?php endif;
                        endforeach; ?>
                    </div>
                </div>
                <div class="button-more">
                    <button type="button" class="btn btn-primary section-button"><?= trans('words', 'View More') ?></button>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>

