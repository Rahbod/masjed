<?php
/** @var $this \yii\web\View */
/** @var $latestNews Post[] */
/* @var $model Post */

use app\models\Post;

$this->title = strip_tags($model->getName());
$baseUrl = $this->theme->baseUrl;
?>

<div class="news-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box">
        <h3><b><?= trans('words', 'News')?></b>
            <small><?= trans('words', 'Mosque of karbala') ?></small>
        </h3>
        <?php if($latestNews):?>
            <div class="similar-news">
                <ul>
                    <?php foreach($latestNews as $news):?>
                        <li>
                            <?php if($src = $news->getImageSrc(true)):?>
                                <img src="<?= $src ?>">
                            <?php endif;?>
                            <div class="info">
                                <h5><?= $news->getName()?></h5>
                                <div class="desc"><?= !empty($news->summary) ? $news->summary : mb_substr(strip_tags(nl2br($news->body)), 0, 200) ?></div>
                            </div>
                            <a href="<?= $news->url ?>"></a>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
        <?php endif;?>
        <a href="<?= \yii\helpers\Url::to(['/post/news']) ?>" class="archive-link hidden-xs"><?= trans('words', 'Project<br>news archive') ?></a>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="text">
            <?php if($src = $model->getPageImageSrc()):?>
                <img src="<?= $src ?>" alt="<?= $model->getName() ?>">
            <?php endif;?>
            <h2><?= $model->getName()?><small><?= $model->getPublishDate()?></small></h2>
            <p><?= $model->body ?></p>
        </div>
        <?php if($model->gallery):?>
            <div class="page-image-gallery">
                <h5><?= trans('words', 'News related pictures') ?></h5>
                <ul>
                    <?php foreach ($model->gallery as $item):?>
                        <li><a href="<?= $item->getAbsoluteUrl() ?>" data-lightbox="img-set-1"><img src="<?= $item->getAbsoluteUrl() ?>"></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
        <?php endif;?>
        <a href="<?= \yii\helpers\Url::to(['/post/news']) ?>" class="archive-link visible-xs"><?= trans('words', 'Project<br>news archive') ?></a>
    </div>
</div>