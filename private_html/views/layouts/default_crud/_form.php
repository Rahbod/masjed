<?php

use app\components\MultiLangActiveRecord;
use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model MultiLangActiveRecord */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
        'id' => 'model-form',
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

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <?= Html::submitButton(trans('words', 'Save'), ['class' => 'btn btn-success']) ?>
        <button type="reset" class="btn btn-secondary"><?= trans('words', 'Cancel') ?></button>
    </div>
</div>
<?php CustomActiveForm::end(); ?>
