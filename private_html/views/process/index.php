<?php

use app\components\customWidgets\CustomActiveForm;
use app\components\Setting;
use app\models\Item;
use app\models\Page;
use app\models\ProjectProcess;
use yii\helpers\Html;
use \app\components\customWidgets\CustomGridView;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel Item */

$this->title = trans('words', $this->context->indexTitle);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <?php Pjax::begin(); ?>

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
							<span><?= trans('words', $this->context->createTitle) ?></span>
						</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>

            <div class="well">

                <?php $form = CustomActiveForm::begin([
                        'id' => 'model-form',
                        'action' => Url::to(['save-more']),
                        'enableAjaxValidation' => false,
                        'enableClientValidation' => true,
                        'validateOnSubmit' => true,
                ]); ?>
                <div class="row">
                    <div class="col-sm-2"><?= Html::label('صفحه نمایش دکمه بیشتر', '',
                                ['class' => 'control-label']) ?></div>
                    <div class="col-sm-6">
                        <?= Html::dropDownList('page_id', Setting::get(ProjectProcess::$morePageSettingKey),
                                Page::getList(),
                                [
                                        'class' => 'form-control',
                                        'prompt' => 'صفحه مورد نظر را انتخاب کنید'
                                ]
                        ) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= Html::submitButton(trans('words', 'Save'),
                                [
                                        'class' => 'btn btn-success'
                                ]
                        ) ?>
                    </div>
                </div>
                <?php CustomActiveForm::end(); ?>
            </div>
        </div>

        <!--begin: Datatable -->
        <div id="m_table_1_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            <?= CustomGridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $searchModel->tableColumns(),
                    'filterModel' => $searchModel,
            ]); ?>
        </div>
    </div>
</div>
<?php Pjax::end(); ?>
</div>
