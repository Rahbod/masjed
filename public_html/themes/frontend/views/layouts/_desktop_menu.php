<?php
/** @var $this View*/

use yii\web\View;

$baseUrl = $this->theme->baseUrl;
?>

<div class="desktop-menu">
    <button type="button" class="close">&times;</button>
    <ul>
        <?php
        /** @var \app\models\Menu $menu */
        foreach (app()->controller->menus as $menu): ?>
            <li<?= $menu->isActive()?' class="active"':'' ?>><a href="<?= $menu->getUrl()?>"<?= $menu->isAnchor()?' class="anchor-link"':'' ?><?= $menu->isAnchor()?' data-anchor="'.$menu->external_link.'"':'' ?>><?= $menu->getName() ?></a></li>
        <?php endforeach; ?>
    </ul>
    <a href="#" class="logo" title="<?= app()->name ?>">
        <img src="<?= $this->theme->baseUrl.'/images/logo.png' ?>" alt="<?= app()->name ?>">
        <h2>
            <span class="arabic"><?= trans('words', 'Great mosque') ?> <span><?= trans('words', 'karbala') ?></span></span>
            <span class="english"><?= trans('words', 'Great mosque', [], 'en') ?> <span><?= trans('words', 'of Karbala', [], 'en') ?></span></span>
        </h2>
    </a>
</div>