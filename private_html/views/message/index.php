<?php

use app\models\Message;
use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MessageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = trans('words', 'Messages');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index">

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
            <div class="m-portlet__head-tools fade">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a href="<?= \yii\helpers\Url::to(['create']) ?>"
                           class="btn btn-accent m-btn m-btn--custom m-btn--pill m-btn--icon m-btn--air">
						<span>
							<i class="la la-plus"></i>
							<span><?= trans('words', 'Create Message') ?></span>
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
                <?php echo Html::beginForm('multiple-delete')?>
                    <?= CustomGridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\CheckboxColumn'],
                            'name',
                            'tel',
                            'subject',
                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return \app\models\Message::getStatusLabels($model->status, true);
                                },
                                'format' => 'raw',
                                'filter' => \app\models\Message::getStatusLabels()
                            ],

                            [
                                'attribute' => 'created',
                                'value' => function($model){
                                    return jDateTime::date('Y/m/d', $model->created);
                                }
                            ],
                            [
                                'class' => 'app\components\customWidgets\CustomActionColumn',
                                'template' => '{view} {delete}'
                            ]
                        ],
                    ]); ?>
                    <input type="submit" class="btn btn-danger" value="حذف دسته جمعی" style="margin-top: 15px;">
                <?php echo Html::endForm();?>
            </div>
        </div>
    </div>
    <?php Pjax::end(); ?>
</div>
