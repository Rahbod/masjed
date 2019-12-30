<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Slide */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'slide-form',
    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

        <?= $form->errorSummary($model) ?>

        <div class="row">
            <?= $model->formRenderer($form, '{field}', 'col-lg-4'); ?>
        </div>

    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(trans('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <button type="reset" class="btn btn-secondary"><?= trans('words', 'Cancel')?></button>
        </div>
    </div>
<?php CustomActiveForm::end(); ?>
