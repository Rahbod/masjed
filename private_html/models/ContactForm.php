<?php

namespace app\models;

use app\components\FormRendererDefinition;
use app\components\FormRendererTrait;
use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model implements FormRendererDefinition
{
    use FormRendererTrait;

    public $name;
    public $email;
    public $tel;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'body', 'tel', 'subject'], 'required'],
//            [['department_id'], 'required', 'on' => 'default'],
//            [['department_id'], 'default', 'value' => Department::find()->one()->id, 'except' => 'default'],
            // email has to be a valid email address
            ['email', 'email'],
//            [['degree'], 'integer', 'max' => 10],
//            [['country', 'city'], 'string', 'max' => 50],
//            [['address'], 'string'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha', 'skipOnEmpty' => false, 'captchaAction' => '/site/captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => trans('words', 'First name and Last name'),
            'email' => trans('words', 'E-Mail'),
            'tel' => trans('words', 'MOBILE NUMBER'),
            'body' => trans('words', 'MESSAGE TEXT'),
            'subject' => trans('words', 'SUBJECT'),

            'department_id' => trans('words', 'Department ID'),
            'verifyCode' => trans('words', 'Verify Code'),
            'degree' => trans('words', 'Degree'),
            'country' => trans('words', 'Country'),
            'city' => trans('words', 'City'),
            'address' => trans('words', 'Address'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {
        if ($this->validate()) {
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([$this->email => $this->name])
                ->setSubject($this->subject)
                ->setTextBody($this->body)
                ->send();

            return true;
        }
        return false;
    }


    public function formAttributes()
    {
        return [
            [['name', 'email', 'tel', 'subject'], [
                'type' => self::FORM_FIELD_TYPE_TEXT,
                'fieldOptions' => [
                    'inputOptions' => ['class' => 'input'],
                    'labelOptions' => ['class' => 'register-label'],
                ]
            ]],
            'body' => [
                'type' => self::FORM_FIELD_TYPE_TEXT_AREA,
                'containerCssClass' => 'col-lg-12',
                'fieldOptions' => [
                    'labelOptions' => ['class' => 'register-label'],
                ],
                'options' => ['class' => 'message-input', 'rows' => 6]
            ],
        ];
    }
}
