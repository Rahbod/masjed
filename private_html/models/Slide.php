<?php

namespace app\models;

use app\components\MainController;
use app\controllers\ProjectController;
use app\controllers\ListController;
use app\controllers\SlideController;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 * @property $image string
 * @property $link string
 *
 */
class Slide extends Item
{
    public static $multiLanguage = false;
    public static $modelName = 'slide';

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
            'link' => ['CHAR', ''],
            'image' => ['CHAR', ''],
            'en_name' => ['CHAR', ''],
            'ar_name' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['image'], 'required'],
            [['link'], 'string'],
            [['en_name', 'ar_name'], 'string'],
            ['modelID', 'default', 'value' => isset(Yii::$app->controller->models[self::$modelName]) ? Yii::$app->controller->models[self::$modelName] : null],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'en_name' => trans('words', 'En Name'),
            'ar_name' => trans('words', 'Ar Name'),
            'link' => trans('words', 'Link'),
            'image' => trans('words', 'Image'),
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

    public function formAttributes()
    {
        return array_merge(parent::formAttributes(), [
            'image' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-12',
                'temp' => MainController::$tempDir,
                'path' => SlideController::$imgDir,
                'filesOptions' => SlideController::$imageOptions,
                'hint' => 'حداقل سایز تصویر: 1920 در 1080 پیکسل',
                'options' => [
                    'url' => Url::to(['upload-image']),
                    'removeUrl' => Url::to(['delete-image']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId(new self(), 'image')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg',
                        'maxFiles' => 1,
                        'maxFileSize' => 5,
                    ],
                ]
            ],
        ]);
    }
}