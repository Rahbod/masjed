<?php
/** @var $this View */
/** @var $block Banner */

/** @var $projects Apartment[] */

/** @var $apartment Apartment */

use app\controllers\ApartmentController;
use app\controllers\ConstructionController;
use app\controllers\InvestmentController;
use app\models\blocks\Banner;
use app\models\Project;
use app\models\projects\Apartment;
use app\models\projects\Investment;
use app\models\projects\OtherConstruction;
use yii\web\View;

switch ($project->type) {
    case Project::TYPE_INVESTMENT:
        $baseUrl = alias('@web') . '/' . InvestmentController::$imgDir . '/';
        break;
    case Project::TYPE_OTHER_CONSTRUCTION:
        $baseUrl = alias('@web') . '/' . ConstructionController::$imgDir . '/';
        break;
    default:
        $baseUrl = alias('@web') . '/' . ApartmentController::$imgDir . '/';
}
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
                                            $apartment = $projects[$j]; ?>
                                            <div class="grid little-post col-lg-3 col-md-6  col-sm-12 col-xs-12">
                                                <a href="<?= $apartment->getUrl() ?>">
                                                    <img src="<?= $baseUrl . $apartment->image ?>"
                                                         alt="<?= $apartment->getName() ?>">
                                                    <h2 class="item-title"><?= $apartment->getName() ?></h2>
                                                    <span class="description"><?= $apartment->getLocationStr() ?><?= $apartment->getLocationTwoStr() ? ' / ' : '' ?></span>
                                                    <span class="description-2"><?= $apartment->getLocationTwoStr() ?></span>
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