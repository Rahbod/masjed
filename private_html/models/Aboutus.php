<?php

namespace app\models;

use app\components\customWidgets\CustomActionColumn;
use Yii;

/**
 * This is the model class for table "item".
 *
 * @property string $description
 * @property string $ar_description
 * @property string $en_description
 */
class Aboutus extends Item
{
    public static $multiLanguage = false;
    public static $modelName = 'about-us';

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
    public function formAttributes()
    {
        return array_merge(parent::formAttributes(),[
                [['description', 'ar_description', 'en_description'], self::FORM_FIELD_TYPE_TEXT_AREA],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
                [['description', 'ar_description', 'en_description'], 'string'],
                ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
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

    /**
     * {@inheritdoc}
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }

    public function getDescriptionStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa') {
                return $this->description;
            } else {
                return $this->{Yii::$app->language . '_description'} ?: $this->description;
            }
        }
        return $this->description;
    }

    public function tableColumns()
    {
        return [
            'name',
            ['class' => CustomActionColumn::className()]
        ];
    }
}
