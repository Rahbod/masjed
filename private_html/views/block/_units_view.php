<?php
/** @var $this View */
/** @var $block Units */
/** @var $project Project */
/** @var $free Unit[] */

/** @var $sold Unit[] */

use app\models\blocks\Units;
use app\models\Project;
use app\models\Unit;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;

$sold = $project->getUnits()->andWhere([Unit::columnGetString('sold') => 1])->orderBy([Unit::columnGetString('sort') => SORT_ASC])->all();
$free = $project->getUnits()->andWhere([Unit::columnGetString('sold') => 0])->orderBy([Unit::columnGetString('sort') => SORT_ASC])->all();
?>

<?php if($sold || $free):?>
<section class="slide-4" id="unit-section">
    <div class="container-fluid">
        <div class="row">
            <div class="slide-title">
                <div class="title-left">
                    <p class="slide"><?= trans('words', '<strong>Current status</strong></br> of the building') ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <?php if ($free): ?>
            <div class="container-fluid">
                <div class="row available">
                    <div class="available-left-title col-lg-3">
                        <img src="<?= $baseUrl.'/images/door-icon.png' ?>" alt="door">
                        <div class="title-unit">
                            <p><?= trans('words', '<span class="green"><strong>{count} unit </span>free </strong>', ['count' => count($free)]) ?></p>
                            <p><?= trans('words', 'from {total_count} unit', ['total_count' => count($sold) + count($free)]) ?> </p>
                        </div>
                        <div class="desc-unit">
                            <p><?= $project->getDescriptionSrc() ?></p>
                        </div>
                    </div>
                    <div class="available-right-title col-lg-9">
                        <div class="item-inner row">
                            <?php foreach ($free as $item): ?>
                                <div class="items col-lg-11 collapsible collapsed" data-toggle="collapse"
                                     data-target="#item-<?= $item->id ?>" aria-expanded="false">
                                    <?= $this->render('//unit/_unit_items', ['model' => $item]) ?>
                                    <div class="item link-more">
                                        <a href="#" data-toggle="collapse" data-target="#item-<?= $item->id ?>"
                                           class="more"><?= trans('words', 'More ...') ?></a>
                                    </div>
                                    <div id="item-<?= $item->id ?>" class="item-list w-100 collapse" style="">
                                        <?= $this->render('//unit/_unit_details', ['model' => $item]) ?>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <p class="free-text"><?= trans('words', 'free') ?></p>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($sold): ?>
            <div class="container-fluid">
                <div class="row sold">
                    <div class="sold-left-title col-lg-3">
                        <p class="sold-title">
                            <?= trans('words', '<span class="red"><strong>{count} unit</strong></span> SOLD', ['count' => count($sold)]) ?>
                        </p>
                    </div>
                    <div class="sold-right-title col-lg-9">
                        <div class="item-inner row">
                            <?php foreach ($sold as $item): ?>
                                <div class="items col-lg-11 collapsible collapsed" data-toggle="collapse"
                                     data-target="#item-<?= $item->id ?>" aria-expanded="false">
                                    <?= $this->render('//unit/_unit_items', ['model' => $item, 'sold' => true]) ?>
                                    <div class="item link-more">
                                        <a href="#" data-toggle="collapse" data-target="#item-<?= $item->id ?>"
                                           class="more"><?= trans('words', 'More ...') ?></a>
                                    </div>
                                    <div id="item-<?= $item->id ?>" class="item-list w-100 collapse" style="">
                                        <?= $this->render('//unit/_unit_details', ['model' => $item]) ?>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <p class="sold-text"><?= trans('words', 'sold') ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif;