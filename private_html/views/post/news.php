<?php
/** @var $this \yii\web\View */
/** @var $searchModel \app\models\Post */
/** @var $dataProvider \yii\data\ActiveDataProvider */
?>
<div class="news-archive-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box line-100">
        <h3><b><?= trans('words', 'News Archive')?></b>
            <small><?= trans('words', 'Mosque of karbala') ?></small>
        </h3>
        <small><?= trans('words', 'news_archive_description') ?></small>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <ul class="news-archive-items">
            <?php echo \yii\widgets\ListView::widget([
                'id' => 'news-list',
                'dataProvider' => $dataProvider,
                'itemView' => '_news_item',
                'layout' => '{items} {pager}'
            ]) ?>
        </ul>
    </div>
</div>