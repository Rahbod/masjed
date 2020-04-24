<?php
/** @var View $this */
/** @var PaymentForm $model */
/* @var $form app\components\customWidgets\CustomActiveForm */

use app\components\customWidgets\CustomActiveForm;
use app\components\customWidgets\CustomCaptcha;
use app\components\FormRendererTrait;
use app\models\PaymentForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

?>
<section>
    <?php $form = ActiveForm::begin([
            'id' => 'payment-form',
            'enableAjaxValidation' => false,
            'enableClientValidation' => true,
            'validateOnSubmit' => true,
    ]); ?>
        <div class="m-portlet__body">
            <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

            <div class="m-form__group m--font-danger"><?= $form->errorSummary($model) ?></div>

            <div class="row">
                <?= $model->formRenderer($form, '{field}', 'col-sm-4'); ?>
            </div>

            <div class="row">
                <div class="captcha">
                    <?= $form->field($model, 'verifyCode')->widget(CustomCaptcha::className(), [
                            'captchaAction' => ['/payment/captcha'],
                            'template' => '{image}{url}{input}',
                            'linkOptions' => [
                                    'label' => trans('words', 'CAPTCHA'),
                                    'class' => 'btn btn-primary captcha-button'
                            ],
                            'options' => [
                                    'class' => 'form-control',
                                    'placeholder' => trans('words', 'Verify Code'),
                                    'tabindex' => ++FormRendererTrait::$tabindex,
                                    'autocomplete' => 'off'
                            ],
                    ])->label(false)->hint(false) ?>
                </div>
            </div>

        </div>
        <div class="m-portlet__foot m-portlet__foot--fit">
            <div class="m-form__actions">
                <?= Html::submitButton(trans('words', 'Payment'), ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</section>
