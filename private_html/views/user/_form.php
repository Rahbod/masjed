<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\components\customWidgets\CustomActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $roles array */
/* @var $groups array */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = CustomActiveForm::begin([
        'id' => 'category-form',
        //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
        'enableAjaxValidation' => true,
        'enableClientValidation' => true,
        'validateOnSubmit' => true,
    ]); ?>

    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

        <?= $form->errorSummary($model) ?>

        <div class="row">
            <div class="col-sm-4">
                <?php if ($model->isNewRecord): ?>
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                <?php else: ?>
                    <div class="form-group m-form__group">
                        <?= Html::label($model->getAttributeLabel('username'), 'username', ['class' => 'col-form-label control-label']) ?>
                        <?= Html::textInput('username', $model->username, ['class' => 'form-control m-input m-input--solid disabled', 'readonly' => true]) ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($model->isNewRecord): ?>
                <div class="col-sm-4">
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                </div>
                <div class="col-sm-4">
                    <?= $form->field($model, 'repeatPassword')->passwordInput(['maxlength' => true]) ?>
                </div>
            <?php endif; ?>
            <div class="col-sm-4">
                <?= $form->field($model, 'roleID')->dropDownList($roles, ['prompt' => 'نقش کاربر را انتخاب کنید']) ?>
            </div>
            <div class="col-sm-4">
                <?php echo $form->field($model, 'status', ['template' => '{label}<label class="switch">{input}<span class="slider round"></span></label>{error}'])->checkbox([], false) ?>
            </div>
        </div>

        <div class="row">
            <?= $model->formRenderer($form, '{field}', 'col-sm-4') ?>
        </div>
    </div>

    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(trans('words', 'Save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php CustomActiveForm::end(); ?>

</div>
