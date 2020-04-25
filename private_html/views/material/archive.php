<?php

/* @var $this yii\web\View */

/* @var $materials Material[] */

use app\models\Material;

$this->title = trans('words', 'Material Assistance');

$baseUrl = $this->theme->baseUrl;
?>
<div class="text-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box">
        <h3><b><?= trans('words', 'Material Assistance') ?></b>
            <small><?= trans('words', 'Material Assistance') ?></small>
        </h3>
        <small>أخبار متعلقة بالتعاون والتقدم في مشروع مسجد كربلاء وشفافية مساهماتكم</small>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <ul class="nav nav-tabs">
            <?php foreach ($materials as $material): ?>
                <li><a data-toggle="tab" href="#material-tab-<?= $material->id ?>"><?= $material->getName() ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php
            $i=0;
            foreach ($materials as $material): ?>
                <div id="material-tab-<?= $material->id ?>" class="tab-pane fade<?= $i++==0?' in active':''?>">
                    <div class="text">
                        <img src="<?= $material->getImageSrc() ?>" alt="<?= $material->getName() ?>">
                        <div><?= $material->getBodyStr() ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
