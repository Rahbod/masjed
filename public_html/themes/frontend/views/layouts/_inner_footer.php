<?php
$baseUrl = $this->theme->baseUrl;

use app\components\MultiLangActiveRecord;
use app\components\Setting;
use yii\helpers\Url; ?>
<footer class="footer-style-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 col-md-5  col-sm-12 col-xs-12 footer-left">
                <div class="row">
                    <div class="col-lg-4 col-md-4  col-sm-12 col-xs-12 logo-footer">
                        <img class="logo-img" src="<?= $baseUrl . '/images/logo-footer-1.png' ?>"
                             alt="<?= app()->name ?>">
                    </div>
                    <div class="col-lg-8 col-md-8  col-sm-12 col-xs-12 text-footer">
                        <div class="footer-title">
                            <p><?= trans('words', 'ABOUT') ?> <?= trans('words', app()->name)  ?></p>
                        </div>
                        <p><?= Setting::get(app()->language.'_about') ?></p>
                        <div class="footer-title"><p><?= trans('words', 'CONTACT US') ?></p></div>
                        <a class="address-link" target="_blank" href="<?= Setting::get('address_link') ?>"><p><?= Setting::get(app()->language == 'fa' ? 'address' : app()->language . '_address') ?></p></a>
                        <div class="phone"><a href="tel:<?= str_replace(' ','',Setting::get('tell')) ?>"><p><strong><?= Setting::get('tell') ?></strong></p></a></div>
                        <?= $this->render('//layouts/_socials')?>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 footer-right">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <nav class="navbar navbar-expand-lg">
                                <div class="collapse navbar-collapse" id="language">
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" id="lang-select"
                                               data-toggle="dropdown" aria-haspopup="true"
                                               aria-expanded="false"><?= strtoupper(app()->language) ?></a>
                                            <div class="dropdown-menu" aria-labelledby="lang-select">
                                                <?php foreach (MultiLangActiveRecord::$showLangArray as $key => $val): ?>
                                                    <a class="dropdown-item"
                                                       href="<?= Url::to(["/$key"]) ?>"><?= $key ?></a>
                                                <?php endforeach; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row">
                        <nav id="footer-menu" class="footer-menu-container">
                            <ul id="main-footer" class="main-menu">
                                <?php
                                /** @var $menu \app\models\Menu */
                                foreach (app()->controller->menus as $menu): ?>
                                    <li class="menu-item">
                                        <a href="<?= $menu->getUrl() ?>"><?= $menu->getName() ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <!-- #main-navigation -->
                        </nav>
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row footer-copy-row">
                        <div class="copy-1 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            © REZVAN.INFO <?= date('Y') ?></br>
                            <?= trans('words', 'REZVAN is a registered trademark of DENSO WAVE INCORPORATED') ?>
                        </div>
                        <div class="copy-2 col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <?= trans('words', 'Design by') ?> : <a title="<?= trans('words', 'Tarsim.inc') ?>" href="http://tarsiminc.com"><?= trans('words', 'Tarsim.inc') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
