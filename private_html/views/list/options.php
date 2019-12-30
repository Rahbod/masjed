<?php

use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ListsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = trans('words', 'List options "{parent}"', ['parent' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => '<span class="m-nav__link-text">' . trans('words', 'Lists') . '</span>', 'url' => ['index'], 'class' => 'm-nav__link'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

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
                        <a href="<?= \yii\helpers\Url::to(['add-option', 'id' => $model->id]) ?>"
                           class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span><?= trans('words', 'Create new option') ?></span>
						</span>
                        </a>
                    </li>
                    <?php if($return = app()->session->get('return')):?>
                        <li class="m-portlet__nav-item">
                            <a href="<?= \yii\helpers\Url::to($return) ?>"
                               class="btn btn-warning m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<span><?= trans('words', 'Back') ?></span>
							<i class="la la-arrow-left"></i>
						</span>
                            </a>
                        </li>
                    <?php endif?>
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
                        'name',
                        [
                            'class' => 'app\components\customWidgets\CustomActionColumn',
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<span class="fas fa-edit text-success" ></span >', ['list/update-option', 'id' => $model->id],
                                        [
                                            'class' => '',
                                            'title' => "ویرایش",
                                            'data-pjax' => 0
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