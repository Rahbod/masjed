<?php
/** @var $this \yii\web\View */
/** @var $latestNews Post[] */

use app\models\Attachment;
use app\models\Post;

/** @var $model \app\models\Post */
/** @var $relatedPosts \app\models\Post[] */
$baseUrl = $this->theme->baseUrl;
$this->registerJsFile($baseUrl . '/js/vendors/html5lightbox/html5lightbox.js', [], 'html5lightbox');

$latestNews = Post::find()->valid()->andWhere(['!=', 'id', $model->id])->orderBy(['id' => SORT_DESC])->limit(8)->all();
?>

<div class="news-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box line-100">
        <h3><b><?= trans('words', 'Project related news') ?></b>
            <small><?= trans('words', 'Mosque of karbala') ?></small>
        </h3>
        <div class="similar-news">
            <ul>
                <?php foreach ($latestNews as $item): ?>
                    <li>
                        <img src="<?= $item->getImageSrc(true) ?>" alt="<?= $item->name ?>">
                        <div class="info">
                            <h5><?= $item->name ?></h5>
                            <div class="desc"><?= $item->summary?></div>
                        </div>
                        <a href="<?= $item->getUrl() ?>"></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="text">
            <img src="<?= $model->getImageSrc() ?>" alt="<?= $model->name ?>">
            <h2><?= $model->name ?><small><?= $model->getDate() ?></small></h2>
            <div><?= $item->body ?></div>
        </div>
        <?php if($model->gallery):?>
        <div class="page-image-gallery">
            <h5><?= trans('words', 'News related pictures') ?></h5>
            <ul>
                <?php
                foreach ($model->gallery as $item):?>
                    <li><a href="#"><img src="<?= $item->getAbsoluteUrl() ?>" alt="item-<?= $item->id ?>"></a></li>
                <?php endforeach;?>
            </ul>
        </div>
        <?php endif;?>
    </div>
</div>
