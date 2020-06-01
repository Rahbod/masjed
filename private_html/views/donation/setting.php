<?php

use app\components\customWidgets\CustomActiveForm;
use app\components\Setting;
use app\models\Page;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $settings [] */

$this->title = trans('words', 'Donation Setting');
//$this->params['breadcrumbs'][] = ['label' => ''];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('
    $("[data-toggle=\'box\']").each(function(){
        var val = $(this).is(":checked"),
            target = $($(this).data("target"));
        target.find(":input").attr("disabled", !val);
    });
    
    $("body").on("change", "[data-toggle=\'box\']", function (e) {
        var val = $(this).is(":checked"),
            target = $($(this).data("target"));
        target.find(":input").attr("disabled", !val);
    });
', \yii\web\View::POS_READY, 'box-toggle');
?>

<div class="m-portlet">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
						<span class="m-portlet__head-icon m--hide">
						<i class="la la-gear"></i>
						</span>
                <h3 class="m-portlet__head-text">
                    <?= Html::encode($this->title) ?>
                </h3>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <?php $form = CustomActiveForm::begin([
        'id' => 'setting-form',
        //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
        'options' => ['class' => 'm-form m-form--label-align-left']
    ]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

        <div class="m-form__section m-form__section--first">
            <div class="m-form__heading">
                <h3 class="m-form__heading-title"><?= trans('words', 'General') ?></h3>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Ussd code'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::textInput('Setting[donation][ussd_code]', $settings['donation']['ussd_code'], [
                        'class' => 'form-control text-right m-input m-input__solid',
                        'dir' => 'ltr'
                    ]); ?>
                </div>
            </div>
        </div>

        <div class="m-form__section m-form__section--first">
            <div class="m-form__heading">
                <h3 class="m-form__heading-title"><?= trans('words', 'Bank Numbers') ?></h3>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'First account'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][fa][bank_name]',
                            isset($settings['donation']['bank_numbers'][0]['fa']['bank_name'])?$settings['donation']['bank_numbers'][0]['fa']['bank_name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Bank name').' - فارسی'
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][ar][bank_name]',
                            isset($settings['donation']['bank_numbers'][0]['ar']['bank_name'])?$settings['donation']['bank_numbers'][0]['ar']['bank_name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Bank name').' - عربی'
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][en][bank_name]',
                            isset($settings['donation']['bank_numbers'][0]['en']['bank_name'])?$settings['donation']['bank_numbers'][0]['en']['bank_name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Bank name').' - انگلیسی'
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][fa][account_type]',
                            isset($settings['donation']['bank_numbers'][0]['fa']['account_type'])?$settings['donation']['bank_numbers'][0]['fa']['account_type']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account type')
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][ar][account_type]',
                            isset($settings['donation']['bank_numbers'][0]['ar']['account_type'])?$settings['donation']['bank_numbers'][0]['ar']['account_type']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account type')
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][en][account_type]',
                            isset($settings['donation']['bank_numbers'][0]['en']['account_type'])?$settings['donation']['bank_numbers'][0]['en']['account_type']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account type')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][fa][account_number]',
                            isset($settings['donation']['bank_numbers'][0]['fa']['account_number'])?$settings['donation']['bank_numbers'][0]['fa']['account_number']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account number')
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][ar][account_number]',
                            isset($settings['donation']['bank_numbers'][0]['ar']['account_number'])?$settings['donation']['bank_numbers'][0]['ar']['account_number']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account number')
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][en][account_number]',
                            isset($settings['donation']['bank_numbers'][0]['en']['account_number'])?$settings['donation']['bank_numbers'][0]['en']['account_number']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account number')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Second account'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][fa][bank_name]',
                        isset($settings['donation']['bank_numbers'][1]['fa']['bank_name'])?$settings['donation']['bank_numbers'][1]['fa']['bank_name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Bank name').' - فارسی'
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][ar][bank_name]',
                        isset($settings['donation']['bank_numbers'][1]['ar']['bank_name'])?$settings['donation']['bank_numbers'][1]['ar']['bank_name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Bank name').' - عربی'
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][en][bank_name]',
                        isset($settings['donation']['bank_numbers'][1]['en']['bank_name'])?$settings['donation']['bank_numbers'][1]['en']['bank_name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Bank name').' - انگلیسی'
                        ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][fa][account_type]',
                        isset($settings['donation']['bank_numbers'][1]['fa']['account_type'])?$settings['donation']['bank_numbers'][1]['fa']['account_type']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account type')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][ar][account_type]',
                        isset($settings['donation']['bank_numbers'][1]['ar']['account_type'])?$settings['donation']['bank_numbers'][1]['ar']['account_type']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account type')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][en][account_type]',
                        isset($settings['donation']['bank_numbers'][1]['en']['account_type'])?$settings['donation']['bank_numbers'][1]['en']['account_type']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account type')
                        ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][fa][account_number]',
                        isset($settings['donation']['bank_numbers'][1]['fa']['account_number'])?$settings['donation']['bank_numbers'][1]['fa']['account_number']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account number')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][ar][account_number]',
                        isset($settings['donation']['bank_numbers'][1]['ar']['account_number'])?$settings['donation']['bank_numbers'][1]['ar']['account_number']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account number')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][en][account_number]',
                        isset($settings['donation']['bank_numbers'][1]['en']['account_number'])?$settings['donation']['bank_numbers'][1]['en']['account_number']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account number')
                        ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Third account'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][fa][bank_name]',
                        isset($settings['donation']['bank_numbers'][2]['fa']['bank_name'])?$settings['donation']['bank_numbers'][2]['fa']['bank_name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Bank name').' - فارسی'
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][ar][bank_name]',
                        isset($settings['donation']['bank_numbers'][2]['ar']['bank_name'])?$settings['donation']['bank_numbers'][2]['ar']['bank_name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Bank name').' - عربی'
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][en][bank_name]',
                        isset($settings['donation']['bank_numbers'][2]['en']['bank_name'])?$settings['donation']['bank_numbers'][2]['en']['bank_name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Bank name').' - انگلیسی'
                        ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][fa][account_type]',
                        isset($settings['donation']['bank_numbers'][2]['fa']['account_type'])?$settings['donation']['bank_numbers'][2]['fa']['account_type']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account type')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][ar][account_type]',
                        isset($settings['donation']['bank_numbers'][2]['ar']['account_type'])?$settings['donation']['bank_numbers'][2]['ar']['account_type']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account type')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][en][account_type]',
                        isset($settings['donation']['bank_numbers'][2]['en']['account_type'])?$settings['donation']['bank_numbers'][2]['en']['account_type']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account type')
                        ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][fa][account_number]',
                        isset($settings['donation']['bank_numbers'][2]['fa']['account_number'])?$settings['donation']['bank_numbers'][2]['fa']['account_number']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account number')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][ar][account_number]',
                        isset($settings['donation']['bank_numbers'][2]['ar']['account_number'])?$settings['donation']['bank_numbers'][2]['ar']['account_number']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account number')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][en][account_number]',
                        isset($settings['donation']['bank_numbers'][2]['en']['account_number'])?$settings['donation']['bank_numbers'][2]['en']['account_number']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Account number')
                        ]); ?>
                </div>
            </div>

        </div>

        <div class="m-form__section m-form__section--first">
            <div class="m-form__heading">
                <h3 class="m-form__heading-title"><?= trans('words', 'Trusted people') ?></h3>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'First person'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][0][fa][name]',
                            isset($settings['donation']['persons'][0]['fa']['name'])?$settings['donation']['persons'][0]['fa']['name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person name').' - فارسی'
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][0][ar][name]',
                            isset($settings['donation']['persons'][0]['ar']['name'])?$settings['donation']['persons'][0]['ar']['name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person name').' - عربی'
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][0][en][name]',
                            isset($settings['donation']['persons'][0]['en']['name'])?$settings['donation']['persons'][0]['en']['name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person name').' - انگلیسی'
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][0][fa][country]',
                            isset($settings['donation']['persons'][0]['fa']['country'])?$settings['donation']['persons'][0]['fa']['country']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person country')
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][0][ar][country]',
                            isset($settings['donation']['persons'][0]['ar']['country'])?$settings['donation']['persons'][0]['ar']['country']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person country')
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][0][en][country]',
                            isset($settings['donation']['persons'][0]['en']['country'])?$settings['donation']['persons'][0]['en']['country']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person country')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][0][fa][mobile]',
                            isset($settings['donation']['persons'][0]['fa']['mobile'])?$settings['donation']['persons'][0]['fa']['mobile']:'', [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                        'placeholder' => trans('words', 'Person mobile')
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][0][ar][mobile]',
                            isset($settings['donation']['persons'][0]['ar']['mobile'])?$settings['donation']['persons'][0]['ar']['mobile']:'', [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                        'placeholder' => trans('words', 'Person mobile')
                    ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][0][en][mobile]',
                            isset($settings['donation']['persons'][0]['en']['mobile'])?$settings['donation']['persons'][0]['en']['mobile']:'', [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                        'placeholder' => trans('words', 'Person mobile')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Second person'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][1][fa][name]',
                        isset($settings['donation']['persons'][1]['fa']['name'])?$settings['donation']['persons'][1]['fa']['name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person name').' - فارسی'
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][1][ar][name]',
                        isset($settings['donation']['persons'][1]['ar']['name'])?$settings['donation']['persons'][1]['ar']['name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person name').' - عربی'
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][1][en][name]',
                        isset($settings['donation']['persons'][1]['en']['name'])?$settings['donation']['persons'][1]['en']['name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person name').' - انگلیسی'
                        ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][1][fa][country]',
                        isset($settings['donation']['persons'][1]['fa']['country'])?$settings['donation']['persons'][1]['fa']['country']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person country')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][1][ar][country]',
                        isset($settings['donation']['persons'][1]['ar']['country'])?$settings['donation']['persons'][1]['ar']['country']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person country')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][1][en][country]',
                        isset($settings['donation']['persons'][1]['en']['country'])?$settings['donation']['persons'][1]['en']['country']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person country')
                        ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][1][fa][mobile]',
                        isset($settings['donation']['persons'][1]['fa']['mobile'])?$settings['donation']['persons'][1]['fa']['mobile']:'', [
                            'class' => 'form-control m-input m-input__solid text-left',
                            'dir' => 'ltr',
                            'placeholder' => trans('words', 'Person mobile')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][1][ar][mobile]',
                        isset($settings['donation']['persons'][1]['ar']['mobile'])?$settings['donation']['persons'][1]['ar']['mobile']:'', [
                            'class' => 'form-control m-input m-input__solid text-left',
                            'dir' => 'ltr',
                            'placeholder' => trans('words', 'Person mobile')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][1][en][mobile]',
                        isset($settings['donation']['persons'][1]['en']['mobile'])?$settings['donation']['persons'][1]['en']['mobile']:'', [
                            'class' => 'form-control m-input m-input__solid text-left',
                            'dir' => 'ltr',
                            'placeholder' => trans('words', 'Person mobile')
                        ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Third person'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][2][fa][name]',
                        isset($settings['donation']['persons'][2]['fa']['name'])?$settings['donation']['persons'][2]['fa']['name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person name').' - فارسی'
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][2][ar][name]',
                        isset($settings['donation']['persons'][2]['ar']['name'])?$settings['donation']['persons'][2]['ar']['name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person name').' - عربی'
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][2][en][name]',
                        isset($settings['donation']['persons'][2]['en']['name'])?$settings['donation']['persons'][2]['en']['name']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person name').' - انگلیسی'
                        ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][2][fa][country]',
                        isset($settings['donation']['persons'][2]['fa']['country'])?$settings['donation']['persons'][2]['fa']['country']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person country')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][2][ar][country]',
                        isset($settings['donation']['persons'][2]['ar']['country'])?$settings['donation']['persons'][2]['ar']['country']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person country')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][2][en][country]',
                        isset($settings['donation']['persons'][2]['en']['country'])?$settings['donation']['persons'][2]['en']['country']:'', [
                            'class' => 'form-control m-input m-input__solid',
                            'placeholder' => trans('words', 'Person country')
                        ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][2][fa][mobile]',
                        isset($settings['donation']['persons'][2]['fa']['mobile'])?$settings['donation']['persons'][2]['fa']['mobile']:'', [
                            'class' => 'form-control m-input m-input__solid text-left',
                            'dir' => 'ltr',
                            'placeholder' => trans('words', 'Person mobile')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][2][ar][mobile]',
                        isset($settings['donation']['persons'][2]['ar']['mobile'])?$settings['donation']['persons'][2]['ar']['mobile']:'', [
                            'class' => 'form-control m-input m-input__solid text-left',
                            'dir' => 'ltr',
                            'placeholder' => trans('words', 'Person mobile')
                        ]); ?>
                    <?php echo Html::textInput('Setting[donation][persons][2][en][mobile]',
                        isset($settings['donation']['persons'][2]['en']['mobile'])?$settings['donation']['persons'][2]['en']['mobile']:'', [
                            'class' => 'form-control m-input m-input__solid text-left',
                            'dir' => 'ltr',
                            'placeholder' => trans('words', 'Person mobile')
                        ]); ?>
                </div>
            </div>
        </div>

        <div class="m-form__section m-form__section--first">
            <div class="m-form__heading">
                <h3 class="m-form__heading-title"><?= trans('words', 'Donation Pages') ?></h3>
            </div>
            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Ussd code page'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::dropDownList('Setting[donation][pages][ussd_page]', $settings['donation']['pages']['ussd_page'], Page::getList(),[
                            'class' => 'form-control m-input m-input__solid',
                        'prompt' => trans('words', 'Please select option')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Online payment page'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::dropDownList('Setting[donation][pages][online_page]', $settings['donation']['pages']['online_page'], Page::getList(),[
                            'class' => 'form-control m-input m-input__solid',
                        'prompt' => trans('words', 'Please select option')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Bank accounts page'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::dropDownList('Setting[donation][pages][bank_page]', $settings['donation']['pages']['bank_page'], Page::getList(),[
                            'class' => 'form-control m-input m-input__solid',
                        'prompt' => trans('words', 'Please select option')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Trusted persons page'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::dropDownList('Setting[donation][pages][person_page]', $settings['donation']['pages']['person_page'], Page::getList(),[
                            'class' => 'form-control m-input m-input__solid',
                        'prompt' => trans('words', 'Please select option')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Objective assistance page'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-6">
                    <?php echo Html::dropDownList('Setting[donation][pages][objective_page]', $settings['donation']['pages']['objective_page'], Page::getList(),[
                            'class' => 'form-control m-input m-input__solid',
                        'prompt' => trans('words', 'Please select option')
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(trans('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= trans('words', 'Cancel') ?></button>
        </div>
    </div>
    <?php CustomActiveForm::end(); ?>

    <!--end::Form-->
</div>