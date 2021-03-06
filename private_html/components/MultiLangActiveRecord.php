<?php

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * MultiLangActiveRecord
 *
 * @property $lang string
 */
abstract class MultiLangActiveRecord extends DynamicActiveRecord
{
    public static $multiLanguage = true;
    public $normalizeValue = false;

    public static $langArray = [
        'fa' => 'فارسی',
        'ar' => 'عربی',
        'en' => 'انگلیسی',
    ];

    public static $showLangArray = [
        'fa' => 'Fa',
        'ar' => 'Ar',
        'en' => 'En',
    ];

    public $dynaDefaults = [
        'lang' => ['CHAR', ''],
    ];

    /**
     * @param $form ActiveForm
     * @param $model DynamicActiveRecord
     * @return mixed
     */
    public static function renderSelectLangInput($form, $model)
    {
        $html = Html::beginTag('div', ['class' => 'row']);
        $html .= Html::beginTag('div', ['class' => 'col-md-4 col-sm-6 col-xs-12']);
        $html .= $form->field($model, 'lang')->dropDownList(self::$langArray, ['class' => 'form-control m-input m-input--solid']);
        $html .= Html::endTag('div');
        $html .= Html::endTag('div');
        return $html;
    }

    public function init()
    {
        parent::init();
        if (static::$multiLanguage) {
            $this->lang = Yii::$app->language;
        } else {
            $this->dynaDefaults = array_merge($this->dynaDefaults, [
                'en_name' => ['CHAR', ''],
                'ar_name' => ['CHAR', ''],

                'en_status' => ['INTEGER', ''],
                'ar_status' => ['INTEGER', ''],
            ]);
        }
    }

    public function rules()
    {
        if (static::$multiLanguage)
            return [
                [['lang'], 'required'],
            ];
        return [
            [['en_status', 'ar_status'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        if (static::$multiLanguage)
            return [
                'lang' => trans('words', 'Lang')
            ];
        return [
            'en_status' => trans('words', 'En Status'),
            'ar_status' => trans('words', 'Ar Status'),
        ];
    }
//
//    public function normalizeValue()
//    {
//        $this->normalizeValue = true;
//    }
//
//    public function __get($name)
//    {
//        $value = parent::__get($name);
//        if($this->normalizeValue && app()->language == 'ar'){
//            if(static::$multiLanguage)
//            $patterns = array('/ی/', '/ک/');
//            $replacements = array('ي', 'ك');
//            return preg_replace($patterns, $replacements, $value);
//        }
//    }
}