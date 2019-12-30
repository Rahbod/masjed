<?php

use app\components\customWidgets\CustomActiveForm;
use app\models\Lists;
use app\models\Request;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Request */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => trans('words', 'Requests'), 'url' => ['index']];
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
                <?= $form->field($model, 'status')->dropDownList(Request::getStatusLabels()) ?>
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
                            return $model->getStatusLabels($model->status, true);
                        },
                        'format' => 'raw'
                    ],
                    'name',
                    'email',
                    'mobile',
                    'phone',
                    'details',
                    [
                        'attribute' => 'created',
                        'value' => jDateTime::date('Y/m/d', $model->created)
                    ],
                ],
            ]) ?>

            <hr>
            <h4>مشخصات عمومی</h4>
            <div class="row">
                <?php
                foreach ($model->dynaDefaults as $key => $config):
                    if (in_array($key, [
                        'email', 'mobile', 'phone', 'details', 'user_lang',
                        'heating_system', 'cooling_system', 'city', 'type_of_buy', 'type_of_unit',
                        'price_from', 'price_to', 'currency',
                        'area_from', 'area_to', 'area_unit',
                        'building_old', 'unit_room'
                    ]))
                        continue;
                    $text = $model->$key == 1 ? '<i class="text-success fa fa-check-circle" style="vertical-align: middle"></i>' : '<i class="text-danger fa fa-times-circle" style="vertical-align: middle"></i>';
                    ?>
                    <div class="col-sm-3 mb-1" <?= $model->$key == 1 ? ' style="background-color:#f0f0f0;border-radius:3px"' : '' ?>>
                        <label class="float-left mt-2 mb-2"><?= $model->getAttributeLabel($key) ?></label>
                        <span class="float-right mt-2 mb-2"><?= $text ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <hr>
            <div class="row">
                <?php
                $otherFields = ['heating_system', 'cooling_system', 'city', 'type_of_buy', 'type_of_unit',
                    'price_from', 'area_from', 'building_old', 'unit_room'];
                foreach ($otherFields as $field):
                    if (in_array($field, ['heating_system', 'cooling_system', 'city', 'type_of_buy', 'type_of_unit'])) {
                        $option = Lists::findOne($model->$field);
                        $text = $option->name;
                    } elseif ($field == 'price_from') {
                        $currency = Lists::findOne($model->currency);
                        $currency = $currency->name;
                        $text = trans('words', 'From') . ': ' . $model->$field?number_format((float)$model->$field):'' . ' ' . $currency .
                            ' - ' . trans('words', 'To') . ': ' . $model->price_to?number_format((float)$model->price_to):'' . ' ' . $currency;
                    } elseif ($field == 'area_from') {
                        $area_unit = Lists::findOne($model->area_unit);
                        $area_unit = $area_unit->name;
                        $text = trans('words', 'From') . ': ' . $model->$field . ' ' . $area_unit .
                            ' - ' . trans('words', 'To') . ': ' . $model->area_to . ' ' . $area_unit;
                    }else
                        $text = $model->$field;
                    ?>
                    <div class="col-sm-3 mb-1" <?= $model->$key == 1 ? ' style="background-color:#f0f0f0;border-radius:3px"' : '' ?>>
                        <label class="float-left mt-2 mb-2"><?= $model->getAttributeLabel($field) ?></label>
                        <span class="float-right mt-2 mb-2"><?= $text ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
