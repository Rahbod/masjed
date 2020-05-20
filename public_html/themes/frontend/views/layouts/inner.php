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

    <link href="<?= $this->theme->baseUrl . '/css/bootstrap.min.css' ?>" rel="stylesheet">
    <?php if (app()->language != 'en'): ?>
        <link href="<?= $this->theme->baseUrl . '/css/bootstrap-rtl.min.css' ?>" rel="stylesheet">
    <?php endif; ?>
    <link href="<?= $this->theme->baseUrl . '/css/bootstrap-4-classes.css' ?>" rel="stylesheet">
    <link href="<?= $this->theme->baseUrl . '/css/font-awesome.css' ?>" rel="stylesheet">
    <link href="<?= $this->theme->baseUrl . '/css/hacen-maghreb.css' ?>" rel="stylesheet">
    <link href="<?= $this->theme->baseUrl . '/css/open-sans.css' ?>" rel="stylesheet">
    <link href="<?= $this->theme->baseUrl . '/css/owl.carousel.min.css' ?>" rel="stylesheet">
    <link href="<?= $this->theme->baseUrl . '/css/owl.theme.default.min.css' ?>" rel="stylesheet">
    <link href="<?= $this->theme->baseUrl . '/css/svg_icons.css' ?>" rel="stylesheet">
    <link href="<?= $this->theme->baseUrl . '/css/lightbox.min.css' ?>" rel="stylesheet">
    <link href="<?= $this->theme->baseUrl . '/css/bootstrap-theme.css' ?>" rel="stylesheet">
    <link href="<?= $this->theme->baseUrl . '/css/responsive-theme.css' ?>" rel="stylesheet">

    <?php if (app()->language != 'en'): ?>

    <?php endif; ?>
</head>
<body class="inner-page<?= app()->language != 'en' ? ' rtl' : '' ?>">
<?php $this->beginBody(); ?>

<main class="content">
    <?= $this->render('_header', array('inner' => true)); ?>

    <?php
    $slides = Slide::find()->valid()->orderBy(['id' => SORT_ASC])->all();

    $processes = ProjectProcess::getLastRows(4, 'id', SORT_ASC);
    $processMoreLink = ProjectProcess::getMoreLink();
    ?>
    <section class="slider-container">
        <div class="slider owl-carousel owl-theme hidden-xs" data-items="1" data-rtl="true">
            <?php
            /** @var Slide $item */
            foreach ($slides as $item):
                $path = alias('@webroot') . DIRECTORY_SEPARATOR . 'uploads/slide' . DIRECTORY_SEPARATOR . $item->image;
                $url = request()->getBaseUrl() . '/uploads/slide/' . $item->image;
                if (is_file($path)):
                    ?>
                    <div class="slide-item relative">
                        <div class="image-container">
                            <img src="<?= $url ?>" alt="<?= $item->getName() ?>">
                        </div>
                    </div>
                <?php
                endif;
            endforeach; ?>
        </div>
        <div class="visible-xs mobile-bg"></div>
    </section>
    <section class="project-intro">
        <div class="top-bar-info">
            <div class="container">
                <div class="top-bar-info__body">
                    <div class="top-bar-info--ring"></div>
                    <div class="top-bar-info--inner">
                        <div class="top-bar-info--cols">
                            <div class="top-bar-info--cols-inner">
                                <div class="top-bar-info_cell dark-red with-icon">
                                    <i class="info-icon"></i>
                                    <span><?= trans('words', 'Project<br>implementation process') ?></span>
                                </div>
                                <?php foreach ($processes as $process): ?>
                                    <div class="top-bar-info_cell">
                                        <i class="line-icon"></i>
                                        <span><?= $process->getName() ?></span>
                                        <span class="bold"><?= $process->getDescriptionStr() ?></span>
                                        <a href="<?= Url::to(['/process/archive?id=' . $process->id]) ?>"></a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="top-bar-info--btn">
                            <a href="<?= Url::to(['/process/archive']) ?>" class="top-bar-info_btn"><?= trans('words', 'More information') ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="inner-page-content">
        <div class="mobile-shape visible-xs"></div>
        <div class="container">
            <?= $content ?>
        </div>
    </section>
    <section class="contact-form-container hidden-xs" id="section-11">
        <div class="body-info">
            <div class="right-side">
                <div class="right-side--header">
                    <h3>
                        <b><?= trans('words', 'Contact us') ?></b>
                        <?= trans('words', 'Mosque of karbala') ?>
                    </h3>
                    <small>أخبار متعلقة بالتعاون والتقدم في مشروع<br>مسجد كربلاء وشفافية مساهماتكم</small>
                </div>
            </div>
            <div class="left-side">
                <div class="contact-us-form-container">
                    <div class="text">لا تتردد في الاتصال بنا عبر النموذج أدناه إذا كنت ترغب في الاتصال بمجموعة مسجد جامع
                        الكربلاء ، أو إذا كان لديك أي نقد أو اقتراحات.
                    </div>
                    <div class="form">
                        <?php
                        $model = new ContactForm();
                        $model->load(Yii::$app->request->post());
                        $form = CustomActiveForm::begin([
                                'id' => 'contact-us-form',
                                'action' => Url::to(['/contact']),
                                'enableAjaxValidation' => false,
                                'enableClientValidation' => true,
                                'validateOnSubmit' => true,
                        ]); ?>
                        <div class="row">
                            <?= $this->render('//layouts/_flash_message') ?>
                            <?= $form->errorSummary($model) ?>
                        </div>
                        <div class="row">
                            <?= $model->formRenderer($form, '{field}', 'col-lg-3 col-md-3 col-sm-3 input-container') ?>
                        </div>
                        <?= Html::textarea(Html::getInputName($model, 'body'), '',
                                ['options' => ['placeholder' => $model->getAttributeLabel('body')]]) ?>
                        <div class="button-container">
                            <div class="pull-right">
                                <?= $this->render('//layouts/_socials') ?>
                            </div>
                            <div class="pull-left captcha-container">
                                <input type="submit" value="<?= trans('words', 'Send') ?>">
                                <?= $form->field($model, 'verifyCode')->widget(CustomCaptcha::className(), [
                                        'captchaAction' => ['/site/captcha'],
                                        'template' => '<div class="input-group"><span class="input-group-addon">{image}</span>{input}</div>',
                                        'options' => [
                                                'class' => 'captcha-control',
//                                            'placeholder' => trans('words', 'Verify Code'),
                                                'tabindex' => ++FormRendererTrait::$tabindex,
                                                'autocomplete' => 'off',
                                        ],
                                ])->label(false)->hint(false) ?>
                            </div>
                        </div>
                        <?php CustomActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= $this->render('_footer'); ?>
</main>
<?= $this->render('_desktop_menu'); ?>

<?php $this->endBody(); ?>


<script src="<?= $this->theme->baseUrl . '/js/bootstrap.min.js' ?>"></script>
<script src="<?= $this->theme->baseUrl . '/js/owl.carousel.min.js' ?>"></script>
<script src="<?= $this->theme->baseUrl . '/js/jquery.nicescroll.min.js' ?>"></script>
<script src="<?= $this->theme->baseUrl . '/js/lightbox.min.js' ?>"></script>
<script src="<?= $this->theme->baseUrl . '/js/jquery.script.js' ?>"></script>
</body>
</html>
<?php $this->endPage(); ?>
