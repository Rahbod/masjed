<?php
/** @var \yii\web\View $this */

use yii\helpers\Url;

?>

<div class="dropdown language-dropdown hidden-xs">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span>Language</span><i></i><?= trans('words', 'fa')?></a>
    <ul class="dropdown-menu dropdown-menu-left">
        <li><a href="<?= Url::to(['/site/index/fa'])?>"><?= trans('words', 'fa')?></a></li>
        <li><a href="<?= Url::to(['/site/index/ar'])?>"><?= trans('words', 'ar')?></a></li>
        <li><a href="<?= Url::to(['/site/index/en'])?>"><?= trans('words', 'en')?></a></li>
    </ul>
</div>