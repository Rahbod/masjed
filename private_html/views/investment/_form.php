<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\projects\Investment */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'investment-form',
    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]); ?>
<div class="m-portlet__body">
    <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

    <div class="row">
        <?= $model->formRenderer($form, '{field}', 'col-lg-4'); ?>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <?= Html::submitButton(trans('words', 'Save'), ['class' => 'btn btn-success']) ?>
        <a href="<?= Url::to(['index']) ?>" data-pjax="false" class="btn btn-danger">
            <?php echo trans('words', 'Cancel') ?></a>
    </div>
</div>
<?php CustomActiveForm::end(); ?>
