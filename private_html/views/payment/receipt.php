<?php

/* @var $this yii\web\View */
/* @var $model app\models\Donation */

$this->title = Yii::t('words', 'Donations');
?>

<div class="image"><img src="<?= $this->theme->baseUrl.'/images/logo.png'?>"></div>
<h2><?php echo trans('words', 'donation_receipt_title')?></h2>
<div class="donation-message"><?php echo trans('words', 'donation_receipt_message')?></div>
<table class="table">
    <tbody>
    <tr class="first-child">
        <th><?php echo $model->getAttributeLabel('name')?></th>
        <td><?php echo $model->name?></td>
    </tr>
    <tr class="odd">
        <th><?php echo $model->getAttributeLabel('mobile')?></th>
        <td><?php echo $model->mobile?></td>
    </tr>
    <tr>
        <th><?php echo $model->getAttributeLabel('amount')?></th>
        <td><?php echo number_format($model->amount)?> تومان</td>
    </tr>
    <tr class="odd">
        <th><?php echo $model->getAttributeLabel('create_date')?></th>
        <td><?php echo date('m/d/Y - H:i', $model->create_date)?></td>
    </tr>
    <tr>
        <th><?php echo $model->getAttributeLabel('invoice_id')?></th>
        <td><?php echo $model->invoice_id?></td>
    </tr>
    </tbody>
</table>
