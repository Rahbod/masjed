<?php

use app\components\customWidgets\CustomActiveForm;
use app\models\Message;
use app\models\Request;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => trans('words', 'Messages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="m-portlet m-portlet--mobile">
    <div class="m-portlet__head">
        <div class="m-portlet__head-caption">
            <div class="m-portlet__head-title">
                <h3 class="m-portlet__head-text">
                    <?= Html::encode($this->title) ?>
                </h3>
            </div>
        </div>
        <div class="m-portlet__head-tools">
            <ul class="m-portlet__nav">
<!--                <li class="m-portlet__nav-item hidden">-->
<!--                    --><?//= Html::a('<span><i class="far fa-edit"></i><span>' . trans('words', 'Update') . '</span></span>', ['update', 'id' => $model->id], [
//                        'class' => 'btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon btn-success',
//                        'encode' => false,
//                    ]) ?>
<!--                </li>-->
                <li class="m-portlet__nav-item">
                    <?= Html::a('<span><i class="far fa-trash-alt"></i><span>' . trans('words', 'Delete') . '</span></span>', ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon btn-danger',
                        'encode' => false,
                        'data' => [
                            'confirm' => trans('words', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]) ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
        <?php $form = CustomActiveForm::begin([
            'id' => 'menu-form',
            'action' => ['update', 'id' => $model->id],
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'validateOnSubmit' => true,
        ]);
        echo Html::hiddenInput('return', 'view');
        ?>
        <div class="row">
            <div class="col-sm-3">
                <?= $form->field($model, 'status')->dropDownList(Message::getStatusLabels()) ?>
            </div>
            <div class="col-sm-3">
                <div style="margin-top: 40px">
                    <?= Html::submitButton(trans('words', 'Save'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>
        </div>
        <?php CustomActiveForm::end(); ?>
        <br>
        <br>

        <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return $model->getStatusLabels($model->status,true);
                        },
                        'format' => 'raw'
                    ],
//                    [
//                        'attribute' => 'status',
//                        'value' => \app\models\Message::getStatusLabels($model->status),
//                        'format' => 'raw'
//                    ],
//                    [
//                        'attribute' => 'department_id',
//                        'value' => $model->department->name,
//                    ],
                    'name',
                    'email',
                    'tel',
                    [
                        'attribute' => 'subject',
                        'value' => function ($model) {
                            return $model->subject?"<b>{$model->subject}</b>":null;
                        },
                        'format' => 'raw'
                    ],
                    'body:ntext',

                    [
                        'attribute' => 'created',
                        'value' => jDateTime::date('Y/m/d', $model->created)
                    ],
                ],
            ]) ?>
        </div>
    </div>
</div>
