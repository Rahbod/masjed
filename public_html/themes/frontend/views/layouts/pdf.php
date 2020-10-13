<?php
/* @var $this \yii\web\View */

/* @var $content string */

use app\components\customWidgets\CustomActiveForm;
use app\components\customWidgets\CustomCaptcha;
use app\components\FormRendererTrait;
use app\models\ContactForm;
use app\models\ProjectProcess;
use app\models\Slide;
use app\themes\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JqueryAsset;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language; ?>">
<head>
    <?php $this->head() ?>
    <meta charset="<?= Yii::$app->charset; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= (($this->title) ? $this->title . ' - ' : '') . trans('words', Yii::$app->name); ?></title>
    <link rel="shortcut icon" href="<?= $this->theme->baseUrl . '/favicon.ico' ?>"/>

    <link href="<?= $this->theme->baseUrl . '/css/bootstrap.min.css' ?>" rel="stylesheet" media="print">
    <?php if (app()->language != 'en'): ?>
        <link href="<?= $this->theme->baseUrl . '/css/bootstrap-rtl.min.css' ?>" rel="stylesheet" media="print">
    <?php endif; ?>
    <link href="<?= $this->theme->baseUrl . '/css/bootstrap-4-classes.css' ?>" rel="stylesheet" media="print">
    <link href="<?= $this->theme->baseUrl . '/css/font-awesome.css' ?>" rel="stylesheet" media="print">
    <?php if(app()->language == 'fa'):?>
        <link href="<?= $this->theme->baseUrl . '/css/fontiran.css' ?>" rel="stylesheet" media="print">
    <?php endif;?>
    <?php if(app()->language == 'ar'):?>
        <link href="<?= $this->theme->baseUrl . '/css/hacen-maghreb.css' ?>" rel="stylesheet" media="print">
    <?php endif;?>
    <link href="<?= $this->theme->baseUrl . '/css/open-sans.css' ?>" rel="stylesheet" media="print">
    <link href="<?= $this->theme->baseUrl . '/css/bootstrap-theme.css' ?>" rel="stylesheet" media="print">
    <?php if(app()->language == 'en'):?>
        <link href="<?= $this->theme->baseUrl . '/css/bootstrap-theme-ltr.css' ?>" rel="stylesheet" media="print">
    <?php endif;?>
    <?php if(app()->language == 'fa'):?>
        <link href="<?= $this->theme->baseUrl . '/css/bootstrap-theme-fa.css' ?>" rel="stylesheet" media="print">
    <?php endif;?>
    <link href="<?= $this->theme->baseUrl . '/css/responsive-theme.css' ?>" rel="stylesheet" media="print">
    <?php if(app()->language == 'en'):?>
        <link href="<?= $this->theme->baseUrl . '/css/responsive-theme-ltr.css' ?>" rel="stylesheet" media="print">
    <?php endif;?>
</head>
<body class="inner-page<?= app()->language != 'en' ? ' rtl' : '' ?>">
<?php $this->beginBody(); ?>
<div class="pdf-box">
    <?= $content ?>
</div>
<?php $this->endBody(); ?>


<script src="<?= $this->theme->baseUrl . '/js/bootstrap.min.js' ?>"></script>
</body>
</html>
<?php $this->endPage(); ?>
