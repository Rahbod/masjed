<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property string slug
 */
class Lists extends Category
{

    public static $typeName = self::TYPE_LIST;

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'slug' => ['CHAR', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            ['slug', 'required', 'except' => ['option-insert', 'option-update']],
            ['slug', 'string'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
        ]);
    }

    public function formAttributes()
    {
        return array_merge(parent::formAttributes(),[
            'slug' => ['type' => self::FORM_FIELD_TYPE_TEXT, 'visible' => app()->session->has('slug')]
        ]);
    }

    public function formOptionsAttributes()
    {
        return parent::formAttributes();
    }
}
