<?php
$baseUrl = $this->theme->baseUrl;

use app\components\MultiLangActiveRecord;
use app\models\Menu;
use yii\helpers\Url; ?>

<header id="header" class="site-header header-style-2">
    <div class="header-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="header-inner clearfix">
                        <div id="site-branding" class="site-branding">
                            <h1 id="site-title" class="logo img-logo">
                                <a href="<?= Url::to(['/site/index']) ?>">
                                    <?php if (app()->language == 'ar'): ?>
                                        <img id="site-logo" src="<?= $baseUrl . '/images/logo-ar.png' ?>"
                                             alt="<?= app()->name ?>">
                                        <img id="site-logo-2" src="<?= $baseUrl . '/images/logo-ar-2.png' ?>"
                                             alt="<?= app()->name ?>">
                                    <?php else: ?>
                                        <img id="site-logo" src="<?= $baseUrl . '/images/logo.png' ?>"
                                             alt="<?= app()->name ?>">
                                        <img id="site-logo-2" src="<?= $baseUrl . '/images/logo-02.png' ?>"
                                             alt="<?= app()->name ?>">
                                    <?php endif; ?>
                                    <span class="site-title"><?= app()->name ?></span>
                                </a>
                            </h1>
                        </div>
                        <!-- .site-branding -->
                        <?= $this->render('//layouts/_socials') ?>
                    </div>
                </div>
                <div class="col-lg-10 col-md-10">
                    <div class="row">
                        <nav id="menu-main" class="main-menu-container navbar-expand-lg">
                            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                                    data-target="#main-navigation" aria-controls="main-navigation" aria-expanded="false"
                                    aria-label="Toggle navigation">
                                <i class="fa fa-bars"></i>
                            </button>
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse" id="language">
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="lang-select"
                                               data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false"><?= strtoupper(app()->language) ?></a>
                                            <div class="dropdown-menu" aria-labelledby="lang-select">
                                                <?php foreach (MultiLangActiveRecord::$showLangArray as $key => $val): ?>
                                                    <a class="dropdown-item"
                                                       href="<?= Url::to(["/$key"]) ?>"><?= $val ?></a>
                                                <?php endforeach; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                            <div id="main-navigation" class="search-container close collapse">
                                <div class="search-box clearfix">
                                    <form role="search" method="get" class="search-form clearfix"
                                          action="<?= Url::to(['/site/search']) ?>">
                                        <input dir="auto" type="search" class="search-field"
                                               placeholder="<?= trans('words', 'Search') ?>"
                                               value="<?= Yii::$app->request->getQueryParam('query') ?>" name="query"
                                               title="<?= trans('words', 'Search') ?>:" autocomplete="off">
                                        <input type="submit" class="search-submit" value="Search">
                                    </form>
                                    <!-- .search-form -->
                                </div>
                            </div>
                            <ul id="main-navigation" class="main-menu collapse">
                                <?php
                                /** @var Menu $menu */

                                foreach (app()->controller->menus as $menu): ?>
                                    <li class="menu-item"><i class="sprite <?= $menu->icon_class ?>"></i><a
                                                href="<?= $menu->getUrl() ?>"><?= $menu->getName() ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- #main-navigation -->
                        </nav>
                        <!-- .main-menu-container -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->context->breadcrumbs): ?>
        <div class="header-bottom">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <p class="breadcrumbs"><?= $this->context->breadcrumbs[0] ?>/</p>
                        <p class="breadcrumbs-desc">
                            <strong><?= $this->context->breadcrumbs[1] ?></strong> <?= $this->context->breadcrumbs[2] ?>
                        </p>
                    </div>

                    <div class="col-lg-6 right">
                        <?php if (isset($this->context->submenu['gallery']) && $this->context->submenu['gallery']): ?>
                            <a href="#gallery-<?= $this->context->submenu['gallery']->id ?>" class="unit lazy-scroll"><?= trans('words', 'gallery') ?></a>
                        <?php endif; ?>
                        <?php if (isset($this->context->submenu['video']) && $this->context->submenu['video']): ?>
                            <a href="#video-section-<?= $this->context->submenu['video']->id ?>" class="unit lazy-scroll"><?= trans('words', 'video') ?></a>
                        <?php endif; ?>
                        <?php if (isset($this->context->submenu['unit']) && $this->context->submenu['unit']): ?>
                            <a href="#unit-section" class="unit lazy-scroll"><?= trans('words', 'unit') ?></a>
                        <?php endif; ?>
                        <?php if (isset($this->context->submenu['map']) && $this->context->submenu['map']): ?>
                            <a href="#map-section" class="on-map lazy-scroll"><?= trans('words', 'on map') ?></a>
                        <?php endif; ?>
                        <?php if (isset($this->context->submenu['nearby']) && $this->context->submenu['nearby']): ?>
                            <a href="#nearby-section" class="near-you lazy-scroll"><?= trans('words', 'near you') ?></a>
                        <?php endif; ?>
                        <?php if (isset($this->context->submenu['contact']) && $this->context->submenu['contact']): ?>
                            <a href="#contact-section" class="near-you lazy-scroll"><?= trans('words', 'Contact') ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</header>
