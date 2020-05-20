<?php

use app\models\Category;
use app\models\Gallery;
use app\models\PictureGallery;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $categories Category[] */

$categories = \app\models\Category::find()
    ->andWhere([
        'type' => \app\models\Category::TYPE_CATEGORY,
        'category_type' => \app\models\Category::CATEGORY_TYPE_PICTURE_GALLERY,
    ])
    ->all();

$categoryID = Yii::$app->request->getQueryParam('category') ?: 0;
$baseUrl = $this->theme->baseUrl;
//$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/froogaloop2.min.js', [], 'froogaloop2');
//$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/html5lightbox.js', [], 'html5lightbox');
?>

<div class="gallery-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box">
        <h3><b><?= trans('words', 'Picture Gallery') ?></b>
            <small><?= trans('words', 'Mosque of karbala') ?></small>
        </h3>
        <small>اقترب من هذا المشروع عن طريق إنشاء مقاطع صور</small>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <ul class="nav nav-tabs">
            <?php $i=0; foreach ($categories as $category):?>
                <li class="<?= $i++ == 0 ? 'active' : ''?>"><a data-toggle="tab" href="#picture-gallery-<?= $category->id ?>"><?= $category->getName() ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php
            $i=0;
            foreach ($categories as $category):
                $photos = PictureGallery::getListByCategory($category->id, Gallery::TYPE_PICTURE_GALLERY);
                ?>
                <div id="picture-gallery-<?= $category->id ?>" class="tab-pane fade<?= $i++==0?' in active':'' ?>">
                    <div class="gallery row">
                        <?php foreach ($photos as $photo):?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 gallery-item">
                                <img src="<?= $photo->getThumbImageSrc() ?>" alt="<?= $photo->getName() ?>">
                                <h5><?= $photo->getName() ?></h5>
                                <span><?= $photo->short_description ?></span>
                                <a href="<?= $photo->getImageSrc() ?>" data-lightbox="img-set-<?= $category->id?>" data-title="<?= $photo->getName()?>"></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
<!--                    <a href="#" class="load-more">شاهد المزيد <span>...</span></a>-->
<!--                    <a href="#" class="load-more loading">شاهد المزيد <span>...</span></a>-->
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>