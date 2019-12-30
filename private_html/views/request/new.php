<?php

/* @var $this yii\web\View */

/* @var $model Request */

use app\components\customWidgets\CustomActiveForm;
use app\components\FormRendererTrait;
use app\models\Lists;
use app\models\Request;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;


$this->registerJs("
    $('#request-verifycode-image').trigger('click');
");

?>

<section class="main-submit">
    <div class="slide-title">
        <div class="title-left">
            <!--<img src="<?//= $baseUrl ?>/images/apartment-icon-w.png" alt="apartment-icon">-->
            <div class="text">
                <h2 class="slide"><strong><?= trans('words', 'REGISTER YOUR REQUEST') ?></strong></h2>
            </div>
        </div>
    </div>
    <div class="title-page d-none">
        <div class="container-fluid">
            <div class="row">
                <div class="title">
                    <i></i>
                    <h1><strong><?= trans('words', 'REGISTER YOUR REQUEST') ?></strong></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="main-section-page container-fluid" style="padding: 0 15px">
        <div class="register-text row">
            <div class="col-lg-6 top-section">
                <h2><?= trans('words', '<strong>REGISTER</strong> YOUR PROPERTY DETAILS') ?></h2>
                <p><?= trans('words', 'register_your_property_details_text') ?></p>
            </div>
        </div>

        <?php $form = CustomActiveForm::begin([
            'id' => 'page-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'validateOnSubmit' => true,
        ]); ?>
        <div class="register-text row">
            <div class="col-lg-12 title-center"><?= $this->render('//layouts/_flash_message') ?></div>
            <div class="col-lg-12 title-center">
                <h2><?= trans('words', '<strong>GENERAL</strong> PROPERTY SPECIFICATIONS') ?></h2></div>

            <div class="col-lg-7 center-section">
                <div class="back-general-post switch row">
                    <div class="col-lg-6">
                        <?= $model->formRenderer($form, '{field}', 'switch-item', 'formGeneralAttributesLeft') ?>
                    </div>
                    <div class="col-lg-6 gray">
                        <?= $model->formRenderer($form, '{field}', 'switch-item', 'formGeneralAttributesLeftGray') ?>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 center-section">
                <div class="back-general-post select">
                    <?php foreach ($model->formGeneralAttributesRight() as $field => $config): ?>
                        <div class="switch-item row">
                            <div class="col-lg-4">
                                <label><?= $model->getAttributeLabel($field) ?></label>
                            </div>
                            <div class="col-lg-8">
                                <?php
                                if ($config['type'] == Request::FORM_FIELD_TYPE_SELECT):
                                    $items = [];
                                    $list = Lists::find()->andWhere([Lists::columnGetString('slug') => $config['listSlug']])->one();
                                    if ($list) {
                                        $list_options = Lists::find()->andWhere(['parentID' => $list->id])->all();
                                        if ($list_options)
                                            $items = ArrayHelper::map($list_options, 'id', function ($model) {
                                                return $model->getName();
                                            });
                                    }
                                    echo Html::dropDownList(Html::getInputName($model, $field), $model->$field, $items, ['class' => 'form-control']);
                                elseif ($field == 'price_from'):
                                    $items = [];
                                    $list = Lists::find()->andWhere([Lists::columnGetString('slug') => 'currency'])->one();
                                    if ($list) {
                                        $list_options = Lists::find()->andWhere(['parentID' => $list->id])->all();
                                        if ($list_options)
                                            $items = ArrayHelper::map($list_options, 'id', function ($model) {
                                                return $model->getName();
                                            });
                                    }
                                    ?>
                                    <?= Html::textInput(Html::getInputName($model, 'price_from'), $model->$field, ['class' => 'form-control select-inline', 'placeholder' => trans('words', 'From')]); ?>
                                    <?= Html::textInput(Html::getInputName($model, 'price_to'), $model->price_to, ['class' => 'form-control select-inline', 'placeholder' => trans('words', 'To')]); ?>
                                    <?= Html::dropDownList(Html::getInputName($model, 'currency'), $model->currency, $items, ['class' => 'form-control select-inline']); ?>
                                <?php elseif ($field == 'area_from'):
                                    $items = [];
                                    $list = Lists::find()->andWhere([Lists::columnGetString('slug') => 'area_unit'])->one();
                                    if ($list) {
                                        $list_options = Lists::find()->andWhere(['parentID' => $list->id])->all();
                                        if ($list_options)
                                            $items = ArrayHelper::map($list_options, 'id', function ($model) {
                                                return $model->getName();
                                            });
                                    }
                                    ?>
                                    <?= Html::textInput(Html::getInputName($model, 'area_from'), $model->$field, ['class' => 'form-control select-inline', 'placeholder' => trans('words', 'From')]); ?>
                                    <?= Html::textInput(Html::getInputName($model, 'area_to'), $model->area_to, ['class' => 'form-control select-inline', 'placeholder' => trans('words', 'To')]); ?>
                                    <?= Html::dropDownList(Html::getInputName($model, 'area_unit'), $model->area_unit, $items, ['class' => 'form-control select-inline']); ?>
                                <?php else:?>
                                    <?= Html::textInput(Html::getInputName($model, $field), $model->$field, ['class' => 'form-control']); ?>
                                <?php
                                endif;
                                ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="col-lg-12 bottom-section">
                <h2><?= trans('words', '<strong>CONTACT</strong> INFORMATION') ?></h2>
                <div class="back-general-post massage row">
                    <?= $model->formRenderer($form, '{field}', 'col-lg-3') ?>
                </div>
                <div class="buttons">
                    <div class="captcha">
                        <?= $form->field($model, 'verifyCode')->widget(\app\components\customWidgets\CustomCaptcha::className(), [
                            'captchaAction' => ['/request/captcha'],
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
        </div>
        <?php CustomActiveForm::end(); ?>
    </div>
</section>


<style>
    .form-group{
        margin-bottom: 5px;
    }
</style>