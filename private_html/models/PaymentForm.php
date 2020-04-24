<?php

namespace app\models;

use app\components\FormRendererDefinition;
use app\components\FormRendererTrait;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class PaymentForm extends Model implements FormRendererDefinition
{
    use FormRendererTrait;

    public $amount;
    public $payerName;
    public $description;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['amount', 'payerName', 'description'], 'required'],
            [['amount'], 'integer'],
            [['payerName', 'description'], 'string'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'skipOnEmpty' => false, 'captchaAction' => '/payment/captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'payerName' => trans('words', 'Payer Name'),
            'amount' => trans('words', 'Amount'),
            'description' => trans('words', 'Description'),
        ];
    }

    public function formAttributes()
    {
        return [
            [['payerName','description','amount'], [
                'type' => self::FORM_FIELD_TYPE_TEXT,
            ]],
        ];
    }
}
