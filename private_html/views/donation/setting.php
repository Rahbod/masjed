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
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][bank_name]',
                            isset($settings['donation']['bank_numbers'][0]['bank_name'])?$settings['donation']['bank_numbers'][0]['bank_name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Bank name')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][account_type]',
                            isset($settings['donation']['bank_numbers'][0]['account_type'])?$settings['donation']['bank_numbers'][0]['account_type']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account type')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][0][account_number]',
                            isset($settings['donation']['bank_numbers'][0]['account_number'])?$settings['donation']['bank_numbers'][0]['account_number']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account number')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Second account'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][bank_name]',
                            isset($settings['donation']['bank_numbers'][1]['bank_name'])?$settings['donation']['bank_numbers'][1]['bank_name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Bank name')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][account_type]',
                            isset($settings['donation']['bank_numbers'][1]['account_type'])?$settings['donation']['bank_numbers'][1]['account_type']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account type')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][1][account_number]',
                            isset($settings['donation']['bank_numbers'][1]['account_number'])?$settings['donation']['bank_numbers'][1]['account_number']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account number')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Third account'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][bank_name]',
                            isset($settings['donation']['bank_numbers'][2]['bank_name'])?$settings['donation']['bank_numbers'][2]['bank_name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Bank name')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][account_type]',
                            isset($settings['donation']['bank_numbers'][2]['account_type'])?$settings['donation']['bank_numbers'][2]['account_type']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Account type')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][bank_numbers][2][account_number]',
                            isset($settings['donation']['bank_numbers'][2]['account_number'])?$settings['donation']['bank_numbers'][2]['account_number']:'', [
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
                    <?php echo Html::textInput('Setting[donation][persons][0][name]',
                            isset($settings['donation']['persons'][0]['name'])?$settings['donation']['persons'][0]['name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person name')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][0][country]',
                            isset($settings['donation']['persons'][0]['country'])?$settings['donation']['persons'][0]['country']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person country')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][0][mobile]',
                            isset($settings['donation']['persons'][0]['mobile'])?$settings['donation']['persons'][0]['mobile']:'', [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                        'placeholder' => trans('words', 'Person mobile')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Second person'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][1][name]',
                            isset($settings['donation']['persons'][1]['name'])?$settings['donation']['persons'][1]['name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person name')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][1][country]',
                            isset($settings['donation']['persons'][1]['country'])?$settings['donation']['persons'][1]['country']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person country')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][1][mobile]',
                            isset($settings['donation']['persons'][1]['mobile'])?$settings['donation']['persons'][1]['mobile']:'', [
                        'class' => 'form-control m-input m-input__solid text-left',
                        'dir' => 'ltr',
                        'placeholder' => trans('words', 'Person mobile')
                    ]); ?>
                </div>
            </div>

            <div class="form-group m-form__group row">
                <?php echo Html::label(trans('words', 'Third person'), '', ['class' => 'col-lg-2 col-form-label']) ?>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][2][name]',
                            isset($settings['donation']['persons'][2]['name'])?$settings['donation']['persons'][2]['name']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person name')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][2][country]',
                            isset($settings['donation']['persons'][2]['country'])?$settings['donation']['persons'][2]['country']:'', [
                        'class' => 'form-control m-input m-input__solid',
                        'placeholder' => trans('words', 'Person country')
                    ]); ?>
                </div>
                <div class="col-lg-3">
                    <?php echo Html::textInput('Setting[donation][persons][2][mobile]',
                            isset($settings['donation']['persons'][2]['mobile'])?$settings['donation']['persons'][2]['mobile']:'', [
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