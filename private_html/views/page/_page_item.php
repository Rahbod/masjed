<?php
/** @var $model \app\models\Page */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="grid col-lg-3">
    <img src="<?= $project->image ?>"
         alt="<?= Html::encode($project->name) ?> ">
    <a title="<?= Html::encode($project->name) ?>"
       href="<?= Url::to(['/project/show/', 'id' => $project->id]) ?>">
        <h2 class="item-title"><?= Html::encode($project->name) ?></h2>
    </a>
    <span class="description"><?= $project->location ?></span>
</div>

<!---->
<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 mb-4">-->
<!--    <div class="card">-->
<!--        <div class="card-body text-nowrap" style="overflow: hidden;text-overflow: ellipsis">-->
<!--            <a href="--><? //= $model->getUrl() ?><!--">-->
<!--                <h4>--><? //= $model->name ?><!--</h4>-->
<!--                <small class="desc">--><? //= strip_tags($model->body) ?><!--</small>-->
<!--            </a>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->