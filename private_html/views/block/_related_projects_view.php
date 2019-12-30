<?php
/** @var $this View */
/** @var $block Banner */

/** @var $projects Project[] */

/** @var $project Project */

use app\controllers\ProjectController;
use app\models\blocks\Banner;
use app\models\Project;
use yii\web\View;

$baseUrl = alias('@web') . '/' . ProjectController::$imgDir . '/';
?>
<?php if ($projects): ?>
    <section class="order-post">
        <div class="container-fluid">
            <div class="row">
                <div class="title-order-post">
                    <h2 id="txt-order-post">
                        <strong><?= trans('words', 'other projects') ?></strong>
                    </h2>
                </div>
                <div id="order-post" class="carousel slide col-lg-12" data-ride="carousel">
                    <div class="carousel-inner">
                        <?php for ($i = 0; $i <= count($projects); $i = $i + 4): ?>
                            <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                                <div class="posts">
                                    <div class="row">
                                        <?php for ($j = $i; $j < $i + 4; $j++):
                                            if (!isset($projects[$j]))
                                                break;
                                            $project = $projects[$j]; ?>
                                            <div class="grid little-post col-lg-3 col-md-6  col-sm-12 col-xs-12">
                                                <a href="<?= $project->getUrl() ?>">
                                                    <img src="<?= $baseUrl . $project->image ?>"
                                                         alt="<?= $project->getName() ?>">
                                                    <h2 class="item-title"><?= $project->getName() ?></h2>
                                                    <span class="description"><?= $project->getLocationStr() ?><?= $project->getLocationTwoStr() ? ' / ' : '' ?></span>
                                                    <span class="description-2"><?= $project->getLocationTwoStr() ?></span>
                                                </a>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <a class="carousel-control-prev" href="#order-post" data-slide="prev">
                        <i class="fas fa-angle-left"></i>
                    </a>
                    <a class="carousel-control-next" href="#order-post" data-slide="next">
                        <i class="fas fa-angle-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
<?php endif;