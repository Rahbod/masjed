<?php

use app\components\customWidgets\CustomGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UnitSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = trans('words', 'Units');
$this->params['breadcrumbs'][] = ['label' => trans('words', 'Apartments'), 'url' => app()->session->get('return')];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unit-index">

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
							<span><?= trans('words', 'Create unit') ?></span>
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
                            'attribute' => 'project_blocks',
                            'value' => function ($model) {
                                return $model->project_blocks ? "<i class='fa fa-check text-success'></i>" : "<i class='fa fa-times text-danger'></i>";
                            },
                            'format' => 'raw',
                            'filter' => [1 => 'بله', 0 => 'خیر']
                        ],
                        [
                            'attribute' => 'sold',
                            'value' => function ($model) {
                                return $model->sold ? "<i class='fa fa-check text-success'></i>" : "<i class='fa fa-times text-danger'></i>";
                            },
                            'format' => 'raw',
                            'filter' => [1 => 'بله', 0 => 'خیر']
                        ],
                        'area_size',
                        [
                            'class' => 'app\components\customWidgets\CustomActionColumn',
                            'template' => '{block} {clone} {update} {delete}',
                            'buttons' => [
                                'block' => function ($url, $model, $key) {
                                    if (!$model->project_blocks)
                                        return Html::a('<span class="fas fa-bars text-warning" ></span >', ['block/index', 'id' => $model['id']], [
                                                'class' => '',
                                                'title' => "لیست بلوک ها",
                                                'aria-label' => "block",
                                                'data-pjax' => 0,
                                            ]
                                        );
                                    return '';
                                },
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
