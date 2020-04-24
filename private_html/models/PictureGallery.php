<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item".
 *
 */
class PictureGallery extends Gallery
{
    public static $typeName = self::TYPE_PICTURE_GALLERY;

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'thumbnail_image' => ['CHAR', ''],
            'full_image' => ['CHAR', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            [['thumbnail_image', 'full_image'], 'required'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'thumbnail_image' => Yii::t('words', 'Thumbnail Image'),
            'full_image' => Yii::t('words', 'Full Image'),
        ]);
    }

    public function getImageSrc()
    {
        return $this->full_image ? app()->getHomeUrl() . '/uploads/gallery/' . $this->full_image : false;
    }

    public function getThumbImageSrc()
    {
        return $this->thumbnail_image ? app()->getHomeUrl() . '/uploads/gallery/' . $this->thumbnail_image : false;
    }
}
