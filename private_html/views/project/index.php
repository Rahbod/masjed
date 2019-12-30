<?php

use app\components\customWidgets\CustomGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = trans('words', 'Projects');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

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
							<span><?= trans('words', 'Create project') ?></span>
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
                <?= CustomGridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        'name',
                        [
                            'attribute' => 'special',
                            'value' => function ($model) {
                                return \app\models\Slide::getStatusLabels($model->special?:0,true);
                            },
                            'format' => 'raw',
                            'filter' => false
                        ],
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return \app\models\Slide::getStatusLabels($model->status,true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Slide::getStatusFilter()
                        ],
                        [
                            'attribute' => 'en_status',
                            'value' => function ($model) {
                                $model->en_status = $model->en_status ?: 0;
                                return \app\models\Slide::getStatusLabels($model->en_status,true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Slide::getStatusFilter()
                        ],
                        [
                            'attribute' => 'ar_status',
                            'value' => function ($model) {
                                $model->ar_status = $model->ar_status ?: 0;
                                return \app\models\Slide::getStatusLabels($model->ar_status,true);
                            },
                            'format' => 'raw',
                            'filter' => \app\models\Slide::getStatusFilter()
                        ],
                        [
                            'class' => 'app\components\customWidgets\CustomActionColumn',
                            'template' => '{block} {view} {update} {delete}',
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<span class="fas fa-eye text-info" ></span >', ['show', 'id' => $model->id],
                                        [
                                            'class' => '',
                                            'title' => "نمایش",
                                            'aria-label' => "view",
                                            'target' => '_blank',
                                            'data-pjax' => 0

                                        ]
                                    );
                                },
                                'block' => function ($url, $model, $key) {
                                    return Html::a('<span class="fas fa-bars text-warning" ></span >', ['block/index', 'id' => $model->id],
                                        [
                                            'class' => '',
                                            'title' => "لیست بلوک ها",
                                            'aria-label' => "block",
                                            'data-pjax' => 0

                                        ]
                                    );
                                },
//                                'unit' => function ($url, $model, $key) {
//                                    return Html::a('<span class="far fa-building text-dark" ></span >', ['unit/index', 'id' => $model->id],
//                                        [
//                                            'class' => '',
//                                            'title' => "لیست واحدها",
//                                            'aria-label' => "unit",
//                                            'data-pjax' => 0
//
//                                        ]
//                                    );
//                                },
                            ]
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
