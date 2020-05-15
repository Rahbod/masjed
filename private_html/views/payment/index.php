<?php
/** @var View $this */
/** @var PaymentForm $model */

/* @var $form app\components\customWidgets\CustomActiveForm */

use app\components\customWidgets\CustomActiveForm;
use app\components\customWidgets\CustomCaptcha;
use app\components\FormRendererTrait;
use app\components\Setting;
use app\models\Material;
use app\models\Page;
use app\models\PaymentForm;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

$donationSetting = Setting::get('donation');
?>

<div class="donate-page row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 title-box">
        <h3><b><?= trans('words', 'Donate now') ?></b>
            <small><?= trans('words', 'Mosque of karbala') ?></small>
        </h3>
<!--        <small>أخبار متعلقة بالتعاون والتقدم في مشروع مسجد كربلاء وشفافية مساهماتكم</small>-->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#donate-1"><?= trans('words', 'Command code') ?>
                    <small>(<?= trans('words', 'Iran and Iraq') ?>)</small></a></li>
            <li><a data-toggle="tab" href="#donate-2"><?= trans('words', 'Acceleration and International Accounts Network') ?></a></li>
            <li><a data-toggle="tab" href="#donate-3"><?= trans('words', 'Bank account number') ?> <small>(<?= trans('words', 'Iran and Iraq') ?>)</small></a></li>
            <li><a data-toggle="tab" href="#donate-4"><?= trans('words', 'Approved phone number') ?></a></li>
        </ul>
    </div>
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="tab-content donate-content">
            <div id="donate-1" class="tab-pane fade in active">
                <h3><?= trans('words', 'Command code') ?> <small>(<?= trans('words', 'Iran and Iraq') ?>)</small></h3>
                <div class="code"><?= $donationSetting['ussd_code'] ?></div>
                <div class="text"><?php
                    if(isset($donationSetting['ussd_page'])) {
                        $page = Page::findOne($donationSetting['ussd_page']);
                        if($page)
                            echo $page->getBodyStr();
                    }
                    ?></div>
            </div>
            <div id="donate-2" class="tab-pane fade">
                <h3><?= trans('words', 'Acceleration and International Accounts Network') ?></h3>
                <div class="text"><?php
                    if(isset($donationSetting['online_page'])) {
                        $page = Page::findOne($donationSetting['online_page']);
                        if($page)
                            echo $page->getBodyStr();
                    }
                    ?></div>
                <div class="payment-methods">
                    <h3>online payment</h3>
                    <ul>
                        <li data-toggle="modal" data-target="#pay-modal">
                            <div class="image">
                                <img src="<?= $this->theme->baseUrl ?>/images/shetab.png">
                            </div>
                            شبكة التسريع
                        </li>
                    </ul>

                    <div id="pay-modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <h5><?= trans('words', 'Acceleration and International Accounts Network') ?></h5>
                                    <div class="text">
                                        ثم هداه صدق الله العظيم. فلما لاح له من ذلك، أن الروح الحيواني بنوع واحد، وان
                                        عرض له التكثر بوجه ما، فكان يرى النوع بهذا النظر على ان حقيقة الروح
                                    </div>
                                    <?php $form = ActiveForm::begin([
                                            'id' => 'payment-form',
                                            'enableAjaxValidation' => true,
                                            'enableClientValidation' => true,
                                            'validateOnSubmit' => true,
                                            'options' => ['class' => 'form']
                                    ]); ?>

                                    <?= Html::activeTextInput($model, 'payerName',
                                            ['placeholder' => $model->getAttributeLabel( 'payerName')]) ?>
                                    <span class="required">إلزامي *</span>
                                    <?= Html::error($model, 'payerName')?>
                                    <?= Html::activeTextInput($model, 'payerMobile',
                                            ['placeholder' => $model->getAttributeLabel( 'payerMobile')]) ?>

                                    <?= Html::activeTextInput($model, 'amount',
                                            ['placeholder' => $model->getAttributeLabel( 'amount'), 'class' => 'digitFormat']) ?>
                                    <span class="required">إلزامي *</span>
                                    <p style="color: gray"><?= trans('words', 'Rials') ?></p>
                                    <?= Html::submitInput(trans('words', 'Payment')) ?>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="donate-3" class="tab-pane fade">
                <h3><?= trans('words', 'Bank account number') ?> <small>(<?= trans('words', 'Iran and Iraq') ?>)</small></h3>
                <div class="text"><?php
                    if(isset($donationSetting['ussd_page'])) {
                        $page = Page::findOne($donationSetting['ussd_page']);
                        if($page)
                            echo $page->getBodyStr();
                    }
                    ?></div>
                <ul class="bank-accounts">
                    <?php foreach (Setting::get('donation.bank_numbers') as $item):?>
                        <li>
                            <h5><?= $item['bank_name'] ?> <small>(<?= $item['account_type'] ?>)</small></h5>
                            <div class="account-number">
                                <span><?= trans('words', 'Account number') ?></span>
                                <span class="text-left"><?= $item['account_number'] ?></span>
                            </div>
                        </li>
                    <?php endforeach;?>
                </ul>
            </div>
            <div id="donate-4" class="tab-pane fade">
                <h3><?= trans('words', 'Objective assistance') ?></h3>
                <div class="text"><?php
                    if(isset($donationSetting['objective_page'])) {
                        $page = Page::findOne($donationSetting['objective_page']);
                        if($page)
                            echo $page->getBodyStr();
                    }
                    ?></div>
                <div class="panel-group" id="accordion">
                    <?php
                    /** @var Material[] $materials */
                    $materials = Material::find()->valid()->all();
                    $i = 0;
                    foreach ($materials as $material): ?>
                        <div class="panel panel-default<?= $i++==0?' -z-index':''?>">
                            <div class="panel-heading">
                                <div class="panel-title" data-toggle="collapse" data-parent="#accordion"
                                     data-target="#collapse1">
                                    <?php if($material->icon):?>
                                        <img src="<?= $material->getIconSrc() ?>" alt="<?= $material->getName() ?>">
                                    <?php endif;?>
                                    <h5><?= $material->getName() ?> / <small><?= $material->getRequiredAmountStr() ?></small></h5>
                                    <span><?= $material->getDescriptionStr() ?></span>
                                </div>
                            </div>
                            <div id="collapse1" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    <div class="text"><?= $material->getBodyStr() ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>