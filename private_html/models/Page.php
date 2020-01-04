<?php

namespace app\models;

use app\components\MainController;
use app\controllers\PageController;
use app\controllers\PostController;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 * @property $body
 *
 */
class Page extends Item
{
    const PAGE_TYPE = 1;
    const SERVICES_TYPE = 2;

    public static $multiLanguage = false;
    public static $modelName = 'page';
    public static $typeName = self::PAGE_TYPE;

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
            'body' => ['CHAR', ''],
            'en_body' => ['CHAR', ''],
            'ar_body' => ['CHAR', ''],
            'image' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['body'], 'required'],
            [['image', 'en_body', 'ar_body'], 'string'],
            [['type'], 'default', 'value' => static::$typeName],
            ['modelID', 'default', 'value' => isset(Yii::$app->controller->models[self::$modelName]) ? Yii::$app->controller->models[self::$modelName] : null],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'body' => trans('words', 'Body'),
            'ar_body' => trans('words', 'Ar Body'),
            'en_body' => trans('words', 'En Body'),
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


    public static function getList()
    {
        return ArrayHelper::map(Page::find()->valid()->all(), 'id', 'name');
    }

    public function getUrl()
    {
        return Url::to(['/page/show', 'id' => $this->id, 'title' => encodeUrl($this->getName())]);
    }

    public function formAttributes()
    {
        return array_merge(parent::formAttributes(), [
            'image' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-12',
                'temp' => MainController::$tempDir,
                'path' => PageController::$imageDir,
                'filesOptions' => PageController::$imageOptions,
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
                        'maxFileSize' => 0.5,
                    ],
                ]
            ],
            [['body', 'ar_body', 'en_body'], [
                'type' => static::FORM_FIELD_TYPE_TEXT_EDITOR,
                'containerCssClass' => 'col-sm-12',
                'options' => [
                    'options' => ['rows' => 30]
                ]
            ]],
            /* 'gallery' => [
                 'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                 'containerCssClass' => 'col-sm-12',
                 'temp' => MainController::$tempDir,
                 'path' => Attachment::getAttachmentPath(),
                 'filesOptions' => PostController::$galleryOptions,
                 'options' => [
                     'url' => Url::to(['upload-attachment']),
                     'removeUrl' => Url::to(['delete-attachment']),
                     'sortable' => false, // sortable flag
                     'sortableOptions' => [], // sortable options
                     'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'gallery')],
                     'options' => [
                         'createImageThumbnails' => true,
                         'addRemoveLinks' => true,
                         'dictRemoveFile' => 'حذف',
                         'addViewLinks' => true,
                         'dictViewFile' => '',
                         'dictDefaultMessage' => 'جهت آپلود تصاویر کلیک کنید',
                         'acceptedFiles' => 'png, jpeg, jpg',
                         'maxFiles' => 10,
                         'maxFileSize' => 0.5,
                     ],
                 ]
             ],*/
        ]);
    }

    public function getBodyStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa')
                return $this->body;
            else
                return $this->{Yii::$app->language . '_body'} ?: $this->body;
        }
        return $this->body;
    }

    public function getModelImage()
    {
        if (isset($this->image) && is_file(Yii::getAlias('@webroot/uploads/page/') . $this->image))
            return Yii::getAlias('@web/uploads/page/') . $this->image;
        return Yii::getAlias('@webapp/public_html/themes/frontend/images/default.jpg');
    }
}