<?php

/* @var $this yii\web\View */
/* @var $model ContactForm */

use app\components\customWidgets\CustomActiveForm;
use app\components\FormRendererTrait;
use app\models\ContactForm;
use yii\helpers\Html;


$this->registerJs("
    $('#request-verifycode-image').trigger('click');
");

?>

<section class="main-submit">
    <div class="slide-title">
        <div class="title-left">
            <div class="text">
                <h2 class="slide"><strong><?= trans('words', 'CONTACT US') ?></strong></h2>
            </div>
        </div>
    </div>
    <div class="main-section-page container-fluid">
        <div class="register-text row">
            <div class="col-lg-6 top-section">
                <h2><?= trans('words', '<strong>CONTACT</strong> US') ?></h2>
                <p><?= trans('words', 'contact_us_text') ?></p>
            </div>

            <?php $form = CustomActiveForm::begin([
                'id' => 'page-form',
                'enableAjaxValidation' => true,
                'enableClientValidation' => true,
                'validateOnSubmit' => true,
                'options' => ['class' => 'w-100']
            ]); ?>
            <div class="col-lg-12 center-section"><?= $this->render('//layouts/_flash_message') ?></div>
            <div class="col-lg-12 bottom-section">
                <div class="back-general-post massage row">
                    <?= $model->formRenderer($form,'{field}', 'col-lg-3') ?>
                    <?= $this->render('//layouts/_socials') ?>
                </div>
                <div class="buttons">
                    <div class="captcha">
                        <?= $form->field($model, 'verifyCode')->widget(\app\components\customWidgets\CustomCaptcha::className(), [
                            'captchaAction' => ['/site/captcha'],
                            'template' => '{image}{url}{input}',
                            'linkOptions' => ['label' => trans('words', 'CAPTCHA'), 'class' => 'btn btn-primary capatcha-button'],
                            'options' => [
                                'class' => 'input',
                                'placeholder' => trans('words', 'Verify Code'),
                                'tabindex' => ++FormRendererTrait::$tabindex,
                                'autocomplete' => 'off'
                            ],
                        ])->label(false)->hint(false) ?>
                    </div>
                    <div class="submit">
                        <?= Html::submitButton(trans('words', 'Submit'), ['class' => 'btn btn-primary submit-button']) ?>
                    </div>
                </div>
            </div>
            <?php CustomActiveForm::end(); ?>
        </div>
    </div>
</section>