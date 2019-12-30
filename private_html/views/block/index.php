<?php

use app\components\customWidgets\CustomActionColumn;
use app\models\Block;
use richardfan\sortable\SortableGridView;
use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BlockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = trans('words', 'Blocks');
$this->params['breadcrumbs'][] = ['label' => trans('words', 'Apartments'), 'url' => app()->session->get('return')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="block-index">

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
                           class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air"
                           data-pjax="false">
						<span>
							<i class="la la-plus"></i>
							<span><?= trans('words', 'Create block') ?></span>
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
                <?= SortableGridView::widget([
                    'sortUrl' => ['sort-item'],
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                            'header' => '',
                            'value' => function(){
                                return '<i class="handle"></i>';
                            },
                            'format' => 'raw',
                            'contentOptions' => ['class' => 'handle-container'],
                            'headerOptions' => ['class' => 'handle-container'],
                        ],
                        'name',
                        [
                            'attribute' => 'type',
                            'value' => function ($model) {
                                /** @var $model Block */
                                return $model->getTypeLabel();
                            }
                        ],
                        //'dyna',
                        //'extra:ntext',
                        //'created',
                        //'status',
                        [
                            'class' => CustomActionColumn::className(),
                            'template' => '{clone} {update} {delete}',
                            'buttons' => [
                                'clone' => function ($url, $model, $key) {
                                    return Html::a('<span class="far fa-copy text-primary" ></span >', ['clone', 'id' => $model['id']], [
                                            'class' => '',
                                            'title' => "تکثیر",
                                            'aria-label' => "clone",
                                            'data-pjax' => 0,
                                        ]
                                    );
                                },
                            ]
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
