<?php

namespace app\models;

use app\controllers\GalleryController;
use Yii;

/**
 * This is the model class for table "item".
 *
 * @property string $video
 * @property string $image
 */
class VideoGallery extends Gallery
{
    public static $typeName = self::TYPE_VIDEO_GALLERY;

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
                'image' => ['CHAR', ''],
                'video' => ['CHAR', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
                ['type', 'default', 'value' => self::$typeName],
                [['image', 'video'], 'required'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
                'image' => Yii::t('words', 'Poster'),
                'video' => Yii::t('words', 'Video'),
        ]);
    }

    public function getVideoSrc()
    {
        return $this->video ? app()->getHomeUrl() . '/uploads/gallery/video/' . $this->video : false;
    }

    public function getPosterSrc()
    {
        return $this->image ? app()->getHomeUrl() . '/uploads/gallery/' . $this->image : false;
    }
}
