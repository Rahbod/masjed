<?php
/** @var View $this */
/** @var Slide[] $slides */
/** @var ProjectProcess[] $processes */
/** @var ProjectSection[] $sections */
/** @var Comments[] $comments */
/** @var Material[] $materials */
/** @var Post[] $news */

/** @var Aboutus[] $aboutus */

use app\components\customWidgets\CustomActiveForm;
use app\components\customWidgets\CustomCaptcha;
use app\components\FormRendererTrait;
use app\components\Setting;
use app\models\Aboutus;
use app\models\Category;
use app\models\Comments;
use app\models\ContactForm;
use app\models\Gallery;
use app\models\Material;
use app\models\Post;
use app\models\ProjectProcess;
use app\models\ProjectSection;
use app\models\ProjectTimeline;
use app\models\Slide;
use app\models\VideoGallery;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

$baseUrl = $this->theme->baseUrl;

$processes = ProjectProcess::getLastRows(4, 'id', SORT_ASC);
$processMoreLink = ProjectProcess::getMoreLink();

$sections = ProjectSection::find()->orderBy(['item.id' => SORT_ASC])->valid()->all();

$videoCategories = Category::getWithType(Category::CATEGORY_TYPE_VIDEO_GALLERY, 'object');
$pictureCategories = Category::getWithType(Category::CATEGORY_TYPE_PICTURE_GALLERY, 'object');

$timelines = ProjectTimeline::getLastRows();
$comments = Comments::find()->valid()->orderBy(['id' => SORT_DESC])->all();
$materials = Material::find()->valid()->all();
$news = Post::find()->valid()->orderBy(['id' => SORT_DESC])->all();
$aboutus = Aboutus::find()->valid()->all();

$this->registerJs("
    $('.captcha-container img').trigger('click');
", View::POS_LOAD);
?>
<section class="project-intro" id="section-2">
    <div class="top-bar-info">
        <div class="container">
            <div class="top-bar-info__body">
                <div class="top-bar-info--ring"></div>
                <div class="top-bar-info--inner" id="project-intro-info">
                    <div class="top-bar-info--cols">
                        <div class="top-bar-info--cols-inner">
                            <div class="top-bar-info_cell dark-red with-icon">
                                <i class="info-icon"></i>
                                <span><?= trans('words', 'Project<br>implementation process') ?></span>
                            </div>
                            <?php foreach ($processes as $process): ?>
                                <div class="top-bar-info_cell">
                                    <i class="line-icon"></i>
                                    <span><?= $process->getName() ?></span>
                                    <span class="bold"><?= $process->getDescriptionStr() ?></span>
                                    <a href="<?= Url::to(['/process/archive?id=' . $process->id]) ?>"></a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="top-bar-info--btn">
                        <a href="<?= Url::to(['/process/archive']) ?>" class="top-bar-info_btn"><?= trans('words', 'More information') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="body-info" id="project-intro">
        <a href="#" class="navbar-toggler hidden-xs">
            <span class="bars-icon"></span>
        </a>
        <div class="right-side">
            <div class="right-side--header">
                <h3>
                    <b><?= trans('words', 'Project sections') ?></b>
                    <?= trans('words', 'Mosque of karbala') ?>
                </h3>
                <small>تقديم أجزاء من الخدمات <br>المتوقعة بعد تشغيل المشروع</small>
            </div>
            <ul class="right-side--menu">
                <?php
                $i = 0;
                foreach ($sections as $section):
                    if ($src = $section->getIconSrc()) {
                        $srcHover = $section->getIconHoverSrc();
                        $this->registerCss('
                        .right-side--menu__icon.section-icon-' . $section->id . ' {
                            background-image: url("'.$src.'");
                        }
                        
                        .right-side--menu > li.active .right-side--menu__icon.section-icon-' . $section->id . ',
                        .right-side--menu > li:hover .right-side--menu__icon.section-icon-' . $section->id . ' {
                            background-image: url("'.$srcHover.'");
                        }', [], 'section-style-'.$section->id);
                    }
                    ?>
                    <li<?= $i++ == 0 ? ' class="active"' : '' ?>>
                        <a href="#" data-toggle="tab" data-target="#project-info-tab-<?= $section->id ?>">
                            <?php if ($src): ?><span class="right-side--menu__icon section-icon-<?= $section->id ?>"></span><?php endif; ?>
                            <div class="right-side--menu__title">
                                <b><?= $section->getName() ?></b>
                                <small><?= $section->getDescriptionStr() ?></small>
                            </div>
                            <span class="right-side--menu__icon-arrow svg-arrow-left-w"></span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <div class="left-side">
            <div class="container-fluid">
                <div class="tab-content">
                    <?php
                    $i = 0;
                    foreach ($sections as $section): ?>
                        <div class="tab-pane fade<?= $i++ == 0 ? ' active in' : '' ?>"
                             id="project-info-tab-<?= $section->id ?>">
                            <div class="left-side--image">
                                <img src="<?= $section->getImageSrc() ?>" alt="<?= $section->getName() ?>">
                            </div>
                            <div class="left-side--info">
                                <h3 class="left-side--info__title"><?= $section->getName() ?></h3>
                                <div class="left-side--info__text">
                                    <div class="left-side--info__text--inner"><?= $section->getBodyStr() ?></div>
                                </div>
                            </div>
                            <div class="left-side--btn">
                                <a href="<?= Url::to(['/payment']) ?>" class="left-side--btn__btn-donate"><?= trans('words',
                                            '<b>Donate</b> now') ?><i class="left-side--btn__heart svg-heart-r"><i
                                                class="left-side--btn__heart-inner svg-heart-filled-r"></i></i></a>
                            </div>
                            <div class="left-side--btn">
                                <a href="<?= $section->getMoreUrl() ?>"
                                   class="left-side--btn__btn-more"><?= trans('words', 'More<br>Information') ?>
                                    <span class="left-side--btn__arrow"></span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-us" id="section-3">
    <div class="body-info" id="contact-us">
        <a href="#" class="navbar-toggler hidden-xs">
            <span class="bars-icon"></span>
        </a>
        <div class="right-side">
            <div class="right-side--header">
                <h3 class="text-white underline-black">
                    <b><?= trans('words', 'how can I help?') ?></b>
                    <?= trans('words', 'Mosque of karbala') ?>
                </h3>
                <small class="text-white"><?= trans('words', 'There are different ways to help you<br>expect how to help') ?></small>
            </div>
            <div class="contact-alert">
                <?= trans('words', 'If you want help and the methods available to you are not possible, refer to the Contact Us and Call Us section.') ?>
            </div>
        </div>
        <div class="left-side">
            <div class="container-fluid">
                <ul class="text-white mobile-carousel owl-carousel owl-theme" data-items="1" data-nav="false" data-dots="true" data-rtl="true">
                    <li>
                        <span class="num">1</span>
                        <h2><?= trans('words', 'Command code') ?>
                            <small>(<?= trans('words', 'Iran and Iraq') ?>)</small>
                        </h2>
                        <span class="left-text"><?= Setting::get('donation.ussd_code') ?></span>
                    </li>
                    <li>
                        <span class="num">2</span>
                        <h2><?= trans('words', 'Acceleration and International Accounts Network') ?></h2>
                        <span class="left-text">online pay</span>
                    </li>
                    <li>
                        <span class="num">3</span>
                        <h2><?= trans('words', 'Bank account number') ?>
                            <small>(<?= trans('words', 'Iran and Iraq') ?>)</small>
                        </h2>
                        <ul class="bank-accounts">
                            <?php foreach (Setting::get('donation.bank_numbers') as $item):if(empty($item['bank_name'])) continue; ?>
                                <li><b><?= $item['bank_name'] ?> <span>(<?= $item['account_type'] ?>)</span></b><?= trans('words', 'Account number') ?><span
                                            class="account-num"><?= $item['account_number'] ?></span>
                                </li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                    <li>
                        <span class="num">4</span>
                        <h2><?= trans('words', 'Approved phone number') ?></h2>
                        <ul class="bank-accounts">
                            <?php foreach (Setting::get('donation.persons') as $item):if(empty($item['name'])) continue; ?>
                                <li><b><?= $item['name'] ?></b><?= $item['country'] ?><span class="account-num"><?= $item['mobile'] ?></span></li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="video-gallery" id="section-4">
    <div class="body-info" id="video-gallery">
        <a href="#" class="navbar-toggler hidden-xs">
            <span class="bars-icon"></span>
        </a>
        <div class="right-side">
            <div class="right-side--header">
                <h3>
                    <b><?= trans('words', 'Video Gallery') ?></b>
                    <?= trans('words', 'Mosque of karbala') ?>
                </h3>
                <small>اقترب من هذا المشروع عن<br>طريق إنشاء مقاطع فيديو</small>
            </div>
        </div>
        <div class="left-side">
            <div class="container-fluid">
                <div class="video-gallery-container">
                    <h4><?= trans('words', 'Categories') ?></h4>
                    <ul class="nav nav-tabs">
                        <?php
                        $i = 0;
                        foreach ($videoCategories as $category):?>
                            <li<?= $i++ == 0 ? ' class="active"' : '' ?>><a data-toggle="tab"
                                                                            href="#video-gallery-tab-<?= $category->id ?>"><?= $category->getName() ?>
                                    <?php if ($str = $category->getDescriptionStr()): echo '<small>(' . $str . ')</small>';endif; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content hidden-xs">
                        <?php
                        $i = 0;
                        foreach ($videoCategories as $category):
                            $videos = VideoGallery::getListByCategory($category->id, Gallery::TYPE_VIDEO_GALLERY);
                            ?>
                            <div id="video-gallery-tab-<?= $category->id ?>"
                                 class="tab-pane fade<?= $i++ == 0 ? ' in active' : '' ?>">
                                <div class="video-slider owl-carousel owl-theme" data-items="1" data-rtl="true"
                                     data-dots="true" data-nav="true">
                                    <?php foreach ($videos as $video): if (!$video->getVideoSrc()) {
                                        continue;
                                    } ?>
                                        <div class="video-item">
                                            <div class="video-container">
                                                <video controls preload="none" poster="<?= $video->getPosterSrc() ?>">
                                                    <source src="<?= $video->getVideoSrc() ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                                <div class="video-overlay"></div>
                                            </div>
                                            <div class="caption">
                                                <i></i>
                                                <h5><?= $video->name ?>
                                                    <small><?= $video->short_description ?>
                                                    </small>
                                                </h5>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php $lastVideos = VideoGallery::getLastList(5, Gallery::TYPE_VIDEO_GALLERY);?>
                    <div class="video-slider owl-carousel owl-theme mobile-carousel visible-xs" data-items="1" data-rtl="true"
                         data-dots="true" data-nav="false">
                        <?php foreach($lastVideos as $video):?>
                            <?php if (!$video->getVideoSrc()) continue;?>
                            <div class="video-item">
                                <div class="video-container">
                                    <video controls preload="none" poster="<?= $video->getPosterSrc() ?>">
                                        <source src="<?= $video->getVideoSrc() ?>" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                    <div class="video-overlay"></div>
                                </div>
                                <div class="caption">
                                    <i></i>
                                    <h5><?= $video->name ?>
                                        <small><?= $video->short_description ?></small>
                                    </h5>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <a href="<?= Url::to(['/gallery/video']) ?>" class="archive-link"><?= trans('words', 'Video Section<br>Archive') ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="image-gallery" id="section-5">
    <div class="body-info" id="image-gallery">
        <a href="#" class="navbar-toggler hidden-xs">
            <span class="bars-icon"></span>
        </a>
        <div class="right-side">
            <div class="right-side--header">
                <h3>
                    <b><?= trans('words', 'Picture Gallery') ?></b>
                    <?= trans('words', 'Mosque of karbala') ?>
                </h3>
                <small>اقترب من هذا المشروع عن<br>طريق إنشاء مقاطع فيديو</small>
            </div>
        </div>
        <div class="left-side">
            <div class="container-fluid">
                <div class="image-gallery-container">
                    <h4><?= trans('words', 'Categories') ?></h4>
                    <ul class="nav nav-tabs">
                        <?php
                        $i = 0;
                        foreach ($pictureCategories as $category):?>
                            <li<?= $i++ == 0 ? ' class="active"' : '' ?>><a data-toggle="tab"
                                                                            href="#picture-gallery-tab-<?= $category->id ?>"><?= $category->getName() ?>
                                    <?php if ($str = $category->getDescriptionStr()): echo '<small>(' . $str . ')</small>';endif; ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content hidden-xs">
                        <?php
                        $i = 0;
                        foreach ($pictureCategories as $category):
                            $photos = Gallery::getListByCategory($category->id, Gallery::TYPE_PICTURE_GALLERY);
                            ?>
                            <div id="picture-gallery-tab-<?= $category->id ?>"
                                 class="tab-pane fade<?= $i++ == 0 ? ' in active' : '' ?>">
                                <div class="image-slider owl-carousel owl-theme" data-margin="15" data-items="1"
                                     data-rtl="true" data-dots="true" data-nav="false">
                                    <?php
                                    $j = 0;
                                    foreach ($photos as $photo):?>
                                        <?php if ($j % 12 == 0): ?><div class="image-item"><?php endif; ?>
                                        <div class="col-lg-3 col-md-3 col-sm-3">
                                            <a href="#"><img src="<?= $photo->getImageSrc() ?>"
                                                             alt="<?= $photo->getName() ?>"></a>
                                        </div>
                                        <?php if ($j % 12 == 0): ?></div><?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php $lastPhotos = Gallery::getLastList(5, Gallery::TYPE_PICTURE_GALLERY);?>
                    <div class="image-slider owl-carousel owl-theme visible-xs mobile-carousel" data-items="1"
                         data-rtl="true" data-dots="true" data-nav="false">
                        <?php foreach($lastPhotos as $photo):?>
                            <div class="image-item">
                                <a href="#"><img src="<?= $photo->getImageSrc() ?>"
                                                 alt="<?= $photo->getName() ?>"></a>
                                <h5 class="visible-xs">
                                    <?= $photo->getName() ?>
<!--                                    <small>صور لأجزاء مختلفة من المسجد في 3D مع إدخال أقسامها الفرعية-->
<!--                                    </small>-->
                                </h5>
                            </div>
                        <?php endforeach;?>
                    </div>
                    <a href="<?= Url::to(['/gallery/video']) ?>" class="archive-link"><?= trans('words', 'Picture Section<br>Archive') ?></a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="time-line-box" id="section-6">
    <div class="body-info" id="timeline">
        <a href="#" class="navbar-toggler hidden-xs">
            <span class="bars-icon"></span>
        </a>
        <div class="title right-side--header">
            <h3>
                <b><?= trans('words', 'Construction steps') ?></b>
                <?= trans('words', 'Mosque of karbala') ?>
            </h3>
            <small>خطوات وكيفية تمويل تكلفة <br>بناء القطاعات بشكل منفصل</small>
        </div>
        <div class="bg"></div>
        <div class="time-line-container">
            <div class="time-line owl-carousel owl-theme" data-items="5" data-rtl="ltr" data-dots="false"
                 data-nav="true" data-responsive='{"0":{"items":3}}'>
                <?php foreach ($timelines as $timeline): ?>
                    <div class="time-line-item <?= $timeline->stateClasses[$timeline->state] ?>">
                        <div class="date">
                            <b><?= $timeline->getDateYear() ?></b>
                            <span><?= $timeline->getDateDayAndMonth() ?></span>
                        </div>
                        <div class="circle"><i></i></div>
                        <div class="text">
                            <?php if ($timeline->state != ProjectTimeline::STATE_DONE): ?><span class="red">
                                <b>$ <?= number_format($timeline->required_amount, 0, '.',
                                            '.') ?></b> <?= trans('words', 'Required Amount') ?></span><?php endif; ?>
                            <?php if ($timeline->state != ProjectTimeline::STATE_TODO): ?><span class="gray">
                                <b>$ <?= number_format($timeline->submitted_amount, 0, '.',
                                            '.') ?></b> <?= trans('words', 'Submitted Amount') ?></span><?php endif; ?>
                        </div>
                        <a href="#time-line-tab-<?= $timeline->id ?>" data-toggle="tab"
                           class="time-line-text-trigger"></a>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="tab-content time-line-text">
                <?php
                $i = 0;
                $c = count($timelines);
                foreach ($timelines as $timeline):?>
                    <div id="time-line-tab-<?= $timeline->id ?>"
                         class="tab-pane fade <?= $timeline->stateClasses[$timeline->state] ?><?= $i++ == 0 ? ' active in' : '' ?>">
                        <h2>
                            <span class="num"><?= $c - $i + 1 ?></span>
                            <span><?= $timeline->getSectionNumberStr() ?></span>
                        </h2>
                        <div class="text-container">
                            <h5><?= $timeline->getName() ?></h5>
                            <div class="text"><?= $timeline->getDescriptionStr() ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="<?= Url::to(['/payment']) ?>" class="btn-donate"><?= trans('words', '<b>Donate</b> now') ?><i
                        class="left-side--btn__heart svg-heart-r"><i
                            class="left-side--btn__heart-inner svg-heart-filled-r"></i></i></a>
        </div>
    </div>
</section>

<section class="media-gallery" id="section-7">
    <div class="body-info" id="media-gallery">
        <a href="#" class="navbar-toggler hidden-xs">
            <span class="bars-icon"></span>
        </a>
        <div class="right-side">
            <div class="right-side--header">
                <h3>
                    <b><?= trans('words', 'Quoted on') ?></b>
                    <?= trans('words', 'Mosque of karbala') ?>
                </h3>
                <small>ونقلت عن هذه المجموعة من<br>اللغات من الزملاء والأشخاص</small>
            </div>
        </div>
        <div class="left-side">
            <div class="container-fluid">
                <div class="media-gallery-container">
                    <div class="media-slider owl-carousel owl-theme" data-items="1" data-rtl="true" data-dots="true"
                         data-nav="false">
                        <?php foreach ($comments as $comment): ?>
                            <div class="media-item">
                                <div class="media-container">
                                    <?php if ($video = $comment->getVideoSrc()): ?>
                                        <video controls preload="none" poster="<?= $comment->getImageSrc() ?>">
                                            <source src="<?= $video ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <div class="video-overlay"></div>
                                    <?php else: ?>
                                        <img src="<?= $comment->getImageSrc() ?>" alt="<?= $comment->getName() ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="caption">
                                    <h5><?= $comment->getName() ?>
                                        <small><?= $comment->getDescriptionStr() ?></small>
                                    </h5>
                                    <div class="text"><?= $comment->getBodyStr() ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="help-container" id="section-8">
    <div class="body-info" id="help">
        <a href="#" class="navbar-toggler hidden-xs">
            <span class="bars-icon"></span>
        </a>
        <div class="right-side--header">
            <h3>
                <b><?= trans('words', 'Objective assistance') ?></b>
                <?= trans('words', 'Mosque of karbala') ?>
            </h3>
            <small>من خلال التبرعات غير النقدية،<br>يمكنك المساعدة في بناءنا</small>
        </div>
        <div class="help-content">
            <?php foreach ($materials as $material): ?>
                <div class="col-lg-4 col-md-4 col-sm-4 help-item">
                    <div class="image">
                        <img src="<?= $material->getIconSrc() ?>" alt="<?= $material->getName() ?>">
                    </div>
                    <h3><?= $material->getName() ?>
                        <small><?= $material->getRequiredAmountStr() ?></small>
                    </h3>
                    <span><?= $material->getDescriptionStr() ?></span>
                    <a href="<?= $material->getMoreUrl() ?>"><?= trans('words', 'More<br>Information') ?><i></i></a>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="<?= Url::to(['/material/archive']) ?>" class="archive-link"><?= trans('words',
                    'More<br>Information') ?></a>
    </div>
</section>

<section class="news-container" id="section-9">
    <div class="body-info" id="news">
        <a href="#" class="navbar-toggler hidden-xs">
            <span class="bars-icon"></span>
        </a>
        <div class="right-side">
            <div class="right-side--header">
                <h3>
                    <b><?= trans('words', 'Project related news') ?></b>
                    <?= trans('words', 'Mosque of karbala') ?>
                </h3>
                <small>أخبار متعلقة بالتعاون والتقدم في مشروع<br>مسجد كربلاء وشفافية مساهماتكم</small>
            </div>
            <a href="<?= Url::to(['/post/news']) ?>" class="archive-link hidden-xs"><?= trans('words', 'Project<br>news archive') ?></a>
        </div>
        <div class="left-side">
            <div class="news-slider owl-carousel owl-theme" data-items="1" data-rtl="true" data-dots="true"
                 data-nav="true">
                <?php foreach ($news as $item): ?>
                    <div class="news-item">
                        <div class="image">
                            <a href="<?= $item->getUrl() ?>"><img src="<?= $item->getImageSrc() ?>"
                                                                  alt="<?= $item->getName() ?>"></a>
                        </div>
                        <div class="info">
                            <h3><?= $item->getName() ?></h3>
                            <div class="text"><?= $item->summary ?></div>
                            <div class="date"><?= $item->getDate() ?></div>
                            <a href="<?= $item->getUrl() ?>" class="more-details hidden-xs"><?= trans('words',
                                        'More information') ?></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="<?= Url::to(['/post/news']) ?>" class="archive-link visible-xs"><?= trans('words', 'Project<br>news archive') ?></a>
        </div>
    </div>
</section>

<section class="about-container hidden-xs" id="section-10">
    <div class="body-info">
        <a href="#" class="navbar-toggler hidden-xs">
            <span class="bars-icon"></span>
        </a>
        <div class="right-side">
            <div class="right-side--header">
                <h3>
                    <b><?= trans('words', 'About us') ?></b>
                    <?= trans('words', 'Mosque of karbala') ?>
                </h3>
                <small>أخبار متعلقة بالتعاون والتقدم في مشروع<br>مسجد كربلاء وشفافية مساهماتكم</small>
            </div>
            <!--            <a href="#" class="attachment-link">استلام كتيب التعريف بالمشروع</a>-->
        </div>
        <div class="left-side">
            <div class="about-content-container">
                <ul class="nav nav-tabs">
                    <?php foreach ($aboutus as $item): ?>
                        <li class="active"><a data-toggle="tab"
                                              href="#about-us-tab-<?= $item->id ?>"><?= $item->getName() ?></a></li>
                    <?php endforeach; ?>
                </ul>
                <div class="tab-content">
                    <?php
                    $i = 0;
                    foreach ($aboutus as $item):?>
                        <div id="about-us-tab-<?= $item->id ?>"
                             class="tab-pane fade<?= $i++ == 0 ? ' in active' : '' ?>">
                            <h3><?= $item->getName() ?></h3>
                            <div class="text"><?= $item->getDescriptionStr() ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="rectangle"></div>
    </div>
</section>