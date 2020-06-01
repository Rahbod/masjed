<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 * @property $short_description
 * @property $body
 * @property $catID
 */
class Gallery extends Item
{
    const TYPE_PICTURE_GALLERY = 1;
    const TYPE_VIDEO_GALLERY = 2;

    public static $modelName = 'gallery';
    public static $multiLanguage = false;

    public static $typeLabels = [
            self::TYPE_PICTURE_GALLERY => 'Picture Gallery',
            self::TYPE_VIDEO_GALLERY => 'Video Gallery'
    ];

    public function getTypeLabel($type = false)
    {
        if (!$type) {
            $type = $this->type;
        }
        return Yii::t('words', ucfirst(self::$typeLabels[$type]));
    }

    public static function getTypeLabels()
    {
        $lbs = [];
        foreach (self::$typeLabels as $key => $label) {
            $lbs[$key] = Yii::t('words', ucfirst($label));
        }
        return $lbs;
    }

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
                'short_description' => ['CHAR', ''],
                'ar_short_description' => ['CHAR', ''],
                'en_short_description' => ['CHAR', ''],
                'body' => ['CHAR', ''],
                'ar_body' => ['CHAR', ''],
                'en_body' => ['CHAR', ''],
                'catID' => ['INTEGER', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
                [['short_description', 'ar_short_description', 'en_short_description', 'formCategories'], 'required'],
                [['short_description'], 'string', 'max' => 255],
                [['body', 'ar_body', 'en_body', ], 'string', 'max' => 1024],
                ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
                ['lang', 'default', 'value' => 'fa'],
//            [['catID'], 'exist', 'skipOnError' => false, 'targetClass' => Category::className(), 'targetAttribute' => ['catID' => 'id']],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
                'short_description' => Yii::t('words', 'Short Description'),
                'ar_short_description' => Yii::t('words', 'Ar Short Description'),
                'en_short_description' => Yii::t('words', 'En Short Description'),
                'body' => Yii::t('words', 'Description'),
                'ar_body' => Yii::t('words', 'Ar Description'),
                'en_body' => Yii::t('words', 'En Description'),
                'catID' => Yii::t('words', 'Category'),
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

    /**
     * @param int $id
     * @param $type
     * @return VideoGallery[]|PictureGallery[]
     */
    public static function getListByCategory($id, $type)
    {
        $query = self::find();
        $query->andWhere(['type' => $type])
            ->andWhere([self::columnGetString('catID') => $id])->valid();
        return $query->all();
    }

    /**
     * @param $count
     * @param $type
     * @return VideoGallery[]|PictureGallery[]
     */
    public static function getLastList($count, $type)
    {
        $query = self::find();
        $query->andWhere(['type' => $type])
            ->limit($count)->valid();
        return $query->all();
    }

    public function beforeSave($insert)
    {
        if ($this->formCategories) {
            $this->catID = $this->formCategories;
        }

        return parent::beforeSave($insert);
    }
}
