<?php

use app\models\Category;
use app\models\Insurance;
use app\models\OnlineService;
use app\models\Post;
use app\models\Slide;
use yii\helpers\Html;
use app\components\Setting;

/* @var $this yii\web\View */
/** @var $slides Slide[] */
/** @var $inpatientInsurances Insurance[] */
/** @var $outpatientInsurances Insurance[] */
/** @var $posts Post[] */
/** @var $galleryCategories Category[] */
/** @var $onlineServices OnlineService[] */

$baseUrl = $this->theme->baseUrl;
$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/froogaloop2.min.js', [], 'froogaloop2');
$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/html5lightbox.js', [], 'html5lightbox');
?>
<section class="slider-container">
    <div class="slider header-slider owl-carousel owl-theme"
        <?= Yii::$app->language == 'en' ? 'data-rtl="false"' : 'data-rtl="true"' ?>
         data-owlcarousel='js:<?= \yii\helpers\Json::encode(Setting::get('slider')); ?>'
         data-items="1"
         data-autoHeight="true">
        <?php foreach ($slides as $slide):
            if ($slide->image && is_file(alias('@webroot/uploads/slide/') . $slide->image)):?>
                <div class="slide-item relative">
                    <div class="image-container">
                        <img src="<?= alias('@web/uploads/slide/') . $slide->image ?>"
                             alt="<?= Html::encode($slide->name) ?>">
                    </div>
                </div>
            <?php endif;endforeach; ?>
    </div>
</section>
