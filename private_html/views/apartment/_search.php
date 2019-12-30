<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\projects\ApartmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apartment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

<!--    --><?//= $form->field($model, 'type') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'dyna') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'status') ?>

    <div class="form-group">
        <?= Html::submitButton(trans('words', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(trans('words', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
