<?php

use app\models\Category;
use app\models\Gallery;
use app\models\PictureGallery;
use app\models\VideoGallery;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $categories Category[] */

$categories = Category::find()
    ->andWhere([
        'type' => Category::TYPE_CATEGORY,
        'category_type' => Category::CATEGORY_TYPE_VIDEO_GALLERY,
    ])
    ->all();

$categoryID = Yii::$app->request->getQueryParam('category') ?: 0;
$baseUrl = $this->theme->baseUrl;
//$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/froogaloop2.min.js', [], 'froogaloop2');
//$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/html5lightbox.js', [], 'html5lightbox');
?>

<div class="gallery-page video row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box">
        <h3><b><?= trans('words', 'Video Gallery') ?></b>
            <small><?= trans('words', 'Mosque of karbala') ?></small>
        </h3>
        <small>اقترب من هذا المشروع عن طريق إنشاء مقاطع صور</small>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <ul class="nav nav-tabs">
            <?php foreach ($categories as $category):?>
                <li><a data-toggle="tab" href="#picture-gallery-<?= $category->id ?>"><?= $category->getName() ?></a></li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php
            $i=0;
            foreach ($categories as $category):
                $videos = VideoGallery::getListByCategory($category->id, Gallery::TYPE_VIDEO_GALLERY);
                ?>
                <div id="picture-gallery-<?= $category->id ?>" class="tab-pane fade<?= $i++==0?' in active':'' ?>">
                    <div class="gallery row">
                        <?php foreach ($videos as $video):?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 gallery-item">
                                <div class="image">
                                    <video controls preload="none" poster="<?= $video->getPosterSrc() ?>">
                                        <source src="<?= $video->getVideoSrc() ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <h5><?= $video->getName() ?></h5>
                                <span><?= $video->short_description ?></span>
                                <a href="<?= $video->getImageSrc() ?>"></a>
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