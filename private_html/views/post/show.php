<?php
/** @var $this \yii\web\View */
/** @var $latestNews Post[] */
/* @var $model Post */

use app\models\Post;

$this->title = strip_tags($model->getName());
$baseUrl = $this->theme->baseUrl;
?>
<div class="text-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box">
        <h3><b><?= $model->getName() ?></b>
<!--            <small>--><?//= $model->sh ?><!--</small>-->
        </h3>
        <small>أخبار متعلقة بالتعاون والتقدم في مشروع مسجد كربلاء وشفافية مساهماتكم</small>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="tab-content">
            <div id="text-1" class="tab-pane fade in active">
                <div class="text">
                    <?php if($src = $model->getImageSrc()):?>
                        <img src="<?= $src ?>" alt="<?= $model->getName() ?>">
                    <?php endif;?>
                    <br><div><?= $model->body ?></div>
                </div>
            </div>
            <?php if($model->gallery):?>
                <div class="gallery">
                    <h5><?= trans('words', 'News related pictures') ?></h5>
                    <?php
                    foreach ($model->gallery as $item):?>
                        <div class="gallery-item"><a href="#"><img src="<?= $item->getAbsoluteUrl() ?>" alt="item-<?= $item->id ?>"></a></div>
                    <?php endforeach;?>
                </div>
            <?php endif;?>
        </div>
    </div>
</div>