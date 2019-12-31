<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MenuSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = trans('words', 'Menus');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                        <a href="<?= \yii\helpers\Url::to(['create']) ?>"
                           class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span><?= trans('words', 'Create Menu') ?></span>
						</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>
            <!--begin: Datatable -->
            <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <?= \richardfan\sortable\SortableGridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'sortUrl' => \yii\helpers\Url::to(['sort-item']),
                    'columns' => [
                        [
                            'header' => '',
                            'value' => function () {
                                return '<i class="handle"></i>';
                            },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'handle-container'],
                            'headerOptions' => ['class' => 'handle-container'],
                        ],
                        'name',
                        [
                            'attribute' => 'parentID',
                            'value' => function ($model) {
                                return $model->parent ? "<b>{$model->parent->name}</b>" : '-';
                            },
                            'filter' => \app\models\Menu::parentsList(),
                            'format' => 'raw'
                        ],
                        [
                            'attribute' => 'menu_type',
                            'value' => function ($model) {
                                return $model->getMenuTypeLabel();
                            },
                        ],
                        [
                            'header' => trans('words', 'Link'),
                            'value' => function ($model) {
                                return $model->getUrl() != "#" ? Html::a(trans('words', 'show'), $model->getUrl(), ['target' => '_blank']) : '-';
                            },
                            'format' => 'raw'
                        ],

                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return \app\models\Slide::getStatusLabels($model->status, true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Slide::getStatusFilter()
                        ],
                        [
                            'attribute' => 'en_status',
                            'value' => function ($model) {
                                $model->en_status = $model->en_status ?: 0;
                                return \app\models\Slide::getStatusLabels($model->en_status, true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Slide::getStatusFilter()
                        ],
                        [
                            'attribute' => 'ar_status',
                            'value' => function ($model) {
                                $model->ar_status = $model->ar_status ?: 0;
                                return \app\models\Slide::getStatusLabels($model->ar_status, true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Slide::getStatusFilter()
                        ],
                        ['class' => 'app\components\customWidgets\CustomActionColumn', 'template' => '{update} {delete}']
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php
    //    var_dump(\yii\helpers\ArrayHelper::map(\app\models\Menu::find()->roots()->all(), 'url', 'name'));exit;
    ?>
    <?php Pjax::end(); ?>
</div>
