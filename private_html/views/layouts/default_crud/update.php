<?php

use app\components\MultiLangActiveRecord;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model MultiLangActiveRecord */

$this->title = trans('words',$this->context->updateTitle, [$this->context->getTitleField() => $model->{$this->context->getTitleField()}]);
$this->params['breadcrumbs'][] = ['label' => trans('words',$this->context->indexTitle), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->{app()->language . '_name'}, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = trans('words', 'Update');
?>


<div class="m-portlet m-portlet--tab">
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
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <!--end::Form-->
</div>