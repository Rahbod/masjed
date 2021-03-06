<?php

use yii\helpers\Html;
use app\components\customWidgets\CustomActiveForm;
use app\models\Menu;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Menu */
/* @var $form app\components\customWidgets\CustomActiveForm */
?>
<?php $form = CustomActiveForm::begin([
    'id' => 'menu-form',
    //'action' => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
    'validateOnSubmit' => true,
]); ?>
    <div class="m-portlet__body">
        <div class="m-form__content"><?= $this->render('//layouts/_flash_message') ?></div>


        <div class="row">
            <?= $model->formRenderer($form,'{field}', 'col-sm-4') ?>
        </div>

        <div class="content-box" style="display: none">

            <?= $form->field($model, 'menu_type')->radioList(Menu::$menuTypeLabels, ['class' => 'menu-type', 'separator' => '<br>']) ?>

            <div class="menu-type-container type-1" style="display: none">
                <div class="row">
                    <div class="col-sm-6">
                        <?= $form->field($model, 'page_id')->dropDownList(\app\models\Page::getList(), ['class' => 'form-control m-input m-input--solid select2', 'data-live-search' => true]) ?>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group m-form__group mt-5">
                            <?= Html::a('<i class="fa fa-plus"></i> '.trans('words', 'Create Page'), ['/page/create', 'return' => Yii::$app->request->url], ['encode' => false, 'class' => 'btn btn-info']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu-type-container type-2" style="display: none">
                <?= Menu::renderMenuActionsSelect($this->context, $model, 'action_name', ['class' => 'form-control m-input m-input--solid'], $form) ?>
            </div>
            <div class="menu-type-container type-3" style="display: none">
                <?= $form->field($model, 'external_link')->textInput() ?>
            </div>
        </div>
    </div>
    <div class="m-portlet__foot m-portlet__foot--fit">
        <div class="m-form__actions">
            <?= Html::submitButton(trans('words', 'Save'), ['class' => 'btn btn-success']) ?>
            <a href="<?= Url::to(['index']) ?>" data-pjax="false" class="btn btn-danger">
                <?php echo trans('words', 'Cancel') ?></a>
        </div>
    </div>
<?php CustomActiveForm::end(); ?>


<?php
$this->registerJs('
    if($("#content-trigger").is(":checked"))
        $(".content-box").show();

    var val = $(".menu-type input:checked").val();
    $(".menu-type-container").not(".type-"+val).hide();
    $(".menu-type-container.type-"+val).show();
    
    $("body").on("change", "#content-trigger", function(){
        if($(this).is(":checked"))
            $(".content-box").show();
        else
            $(".content-box").hide();
    }).on("change", ".menu-type input", function(){
        var val = $(this).val();
        $(".menu-type-container").not(".type-"+val).hide();
        $(".menu-type-container.type-"+val).show();
    });
', \yii\web\View::POS_READY, 'content-trigger');