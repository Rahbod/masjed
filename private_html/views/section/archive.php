<?php

/* @var $this yii\web\View */
/* @var $id integer */
/* @var $sections ProjectSection[] */

use app\models\ProjectSection;

$baseUrl = $this->theme->baseUrl;
?>
<div class="text-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box">
        <h3><b><?= trans('words', 'Section show page')?></b>
<!--            <small>--><?//= $section->getS ?><!--</small>-->
        </h3>
        <small><?= trans('words', 'Section show page description')?></small>
        <ul class="nav nav-tabs right-tab-trigger">
            <?php foreach ($sections as $section): ?>
                <li<?= $section->id == $id ?' class="active"':''?>><a href="#section-<?= $section->id ?>" data-toggle="tab"><?= $section->getName() ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="tab-content">
            <?php foreach ($sections as $section): ?>
                <div id="section-<?= $section->id?>" class="tab-pane fade <?= $section->id == $id ? 'in active' : ''?>">
                    <div class="text">
                        <?php if($src = $section->getModelImage()):?>
                            <img src="<?= $section->getModelImage() ?>" alt="<?= $section->getName() ?>">
                        <?php endif;?>
                        <br><div><?= $section->getBodyStr() ?></div>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
