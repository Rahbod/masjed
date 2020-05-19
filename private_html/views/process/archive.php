<?php

/* @var $this yii\web\View */
/* @var $id integer */

/* @var $processes ProjectProcess[] */

use app\models\ProjectProcess;

$this->title = trans('words', 'Process');

$baseUrl = $this->theme->baseUrl;
?>
<div class="text-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box">
        <h3><b><?= trans('words', 'Process') ?></b>
            <small><?= trans('words', 'Mosque of karbala') ?></small>
        </h3>
        <small><?= trans('words', 'Process Archive Description') ?></small>
        <ul class="nav nav-tabs right-tab-trigger">
            <?php
            $i = 0;
            $processes = array_reverse($processes);
            foreach ($processes as $item): ?>
                <li<?= ($id!=false && $item->id == $id) || ($id == false && $i++==0)?' class="active"':''?>><a data-toggle="tab" href="#process-tab-<?= $item->id ?>"><?= $item->getName() ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="tab-content">
            <?php
            $i=1;
            $processes = array_reverse($processes);
            foreach ($processes as $item): ?>
                <div id="process-tab-<?= $item->id ?>" class="tab-pane fade<?= ($id!=false && $item->id == $id) || ($id == false && $i==count($processes))?' in active':''?>">
                    <div class="text"><?= $item->getTextStr() ?></div>
                </div>
            <?php $i++; endforeach; ?>
        </div>
    </div>
</div>
