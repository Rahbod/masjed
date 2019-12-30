<?php

namespace app\models;

use app\components\MainController;
use app\controllers\PostController;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 * @property string $body
 * @property string description
 * @property string ar_description
 * @property string en_description
 *
 */
class Service extends Page
{

    public static $typeName = self::SERVICES_TYPE;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'description' => ['CHAR', ''],
            'ar_description' => ['CHAR', ''],
            'en_description' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['type'], 'default', 'value' => static::$typeName],
            [['description', 'ar_description', 'en_description'], 'required'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'description' => trans('words', 'Description'),
            'ar_description' => trans('words', 'Ar Description'),
            'en_description' => trans('words', 'En Description'),
        ]);
    }

    public function formAttributes()
    {
        return array_merge(Item::formAttributes(), [
            [
                ['description', 'ar_description', 'en_description'],
                ['type' => static::FORM_FIELD_TYPE_TEXT_AREA, 'containerCssClass' => 'col-sm-4']
            ],
            [['body', 'ar_body', 'en_body'], [
                'type' => static::FORM_FIELD_TYPE_TEXT_EDITOR,
                'containerCssClass' => 'col-sm-12',
                'options' => [
                    'options' => ['rows' => 30]
                ]
            ]],
        ]);
    }

    public static function getList()
    {
        return ArrayHelper::map(Service::find()->valid()->all(), 'id', 'name');
    }

    public function getDescriptionStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa')
                return $this->description;
            else
                return $this->{Yii::$app->language . '_description'} ?: $this->description;
        }
        return $this->description;

    }

    public function getUrl()
    {
        return Url::to(['/service/show', 'id' => $this->id, 'title' => encodeUrl($this->name)]);
    }
}
