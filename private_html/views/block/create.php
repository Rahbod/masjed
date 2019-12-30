<?php

use yii\helpers\Html;
use yii\web\View;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Block */

$this->title = trans('words', 'Create block');
$this->params['breadcrumbs'][] = ['label' => '<span class="m-nav__link-text">' . trans('words', 'Blocks') . '</span>', 'url' => ['index', 'id' => $model->itemID], 'class' => 'm-nav__link'];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('
    $("body").on("change", "#type-trigger", function(){
        var container = "#block-form-pjax";
        var url = $(this).data("url");
        var formData = $(container).find("form").serialize();
        
        $.pjax.reload({
            push: false,
            replace: false,
            timeout: false,
            scrollTo: false,
            container: container,
            url: url,
            type: "post",
            data: {type:$(this).val()}
        });
    });
', View::POS_READY, 'type-trigger');
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
    <?php Pjax::begin([
        'id' => 'block-form-pjax',
        'options' => [
//            'class' => 'custom-modal create-modal',
        ],
        'enablePushState' => false,
        'enableReplaceState' => true,
        'timeout' => 0,
        'formSelector' => false,
    ]) ?>
    <!--begin::Form-->
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
    <!--end::Form-->
    <?php Pjax::end() ?>
</div>