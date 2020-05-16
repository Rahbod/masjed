<?php
/** @var $model \app\models\Post */
?>

<li>
    <div class="image">
        <img src="<?= alias('@web/uploads/post/') . $model->image ?>">
    </div>
    <h4><?= $model->name ?></h4>
    <div class="text"><?= !empty($model->summary) ? $model->summary : mb_substr(strip_tags(nl2br($model->body)), 0, 200) ?></div>
    <div class="date"><?= $model->getPublishDate() ?></div>
    <a href="<?= $model->url ?>" class="link"></a>
</li>