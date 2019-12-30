<?php

use app\models\Service;
use app\models\ServiceSearch;
use yii\data\ActiveDataProvider;
use yii\web\View;

/** @var $this View */
/** @var $searchModel ServiceSearch */
/** @var $dataProvider ActiveDataProvider */
/** @var $model Service */

?>
<ul>
    <?php foreach ($dataProvider->models as $model): ?>
        <li><a href="<?= $model->getUrl() ?>"><?= $model->getName() ?></a></li>
    <?php endforeach; ?>
</ul>
