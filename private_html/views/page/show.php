<?php

/* @var $this yii\web\View */
/* @var $model Page|\app\models\ProjectSection */

use app\models\Page;
use app\models\Project;
use yii\helpers\Html;

$this->title = strip_tags($model->getName());

$baseUrl = $this->theme->baseUrl;
?>
<div class="text-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box">
        <h3><b><?= $model->getName() ?></b>
<!--            <small>--><?//= $model->getS ?><!--</small>-->
        </h3>
        <small>أخبار متعلقة بالتعاون والتقدم في مشروع مسجد كربلاء وشفافية مساهماتكم</small>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="tab-content">
            <div id="text-1" class="tab-pane fade in active">
                <div class="text">
                    <?php if($src = $model->getModelImage()):?>
                        <img src="<?= $model->getModelImage() ?>" alt="<?= $model->getName() ?>">
                    <?php endif;?>
                    <br><div><?= $model->getBodyStr() ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
