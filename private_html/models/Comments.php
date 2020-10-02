<?php

namespace app\models;

use app\components\customWidgets\CustomActionColumn;
use app\components\MainController;
use app\controllers\CommentsController;
use app\controllers\SectionController;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 *
 * @property string $image
 * @property string $video
 * @property string $description
 * @property string $ar_description
 * @property string $en_description
 * @property string $body
 * @property string $ar_body
 * @property string $en_body
 */
class Comments extends Item
{
    public static $multiLanguage = false;
    public static $modelName = 'comments';

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
                'image' => ['CHAR', ''],
                'video' => ['CHAR', ''],

                'description' => ['CHAR', ''],
                'ar_description' => ['CHAR', ''],
                'en_description' => ['CHAR', ''],

                'body' => ['CHAR', ''],
                'ar_body' => ['CHAR', ''],
                'en_body' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
                [
                        [
                                'image',
                                'video',
                                'description',
                                'ar_description',
                                'en_description',
                                'body',
                                'ar_body',
                                'en_body'
                        ],
                        'string'
                ],
                ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
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

    /**
     * {@inheritdoc}
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }

    public function getImageSrc()
    {
        if(is_file(alias('@webroot').DIRECTORY_SEPARATOR.CommentsController::$imageDir.DIRECTORY_SEPARATOR.$this->image)) {
            $path = Yii::$app->request->getBaseUrl();
            return $path . '/' . CommentsController::$imageDir . '/' . $this->image;
        }
        return null;
    }

    public function getVideoSrc()
    {
        return $this->video ? Yii::$app->request->getBaseUrl() . '/'.CommentsController::$videoDir.'/' . $this->video : false;
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

    public function getBodyStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa') {
                return $this->body;
            } else {
                return $this->{Yii::$app->language . '_body'} ?: $this->body;
            }
        }
        return $this->body;
    }

    public function tableColumns()
    {
        return [
            'name',
            ['class' => CustomActionColumn::className()]
        ];
    }

    public function formAttributes()
    {
        return array_merge(parent::formAttributes(), [
            [['description', 'ar_description', 'en_description'], self::FORM_FIELD_TYPE_TEXT_AREA],

            [['body', 'ar_body', 'en_body'], [
                'type' => static::FORM_FIELD_TYPE_TEXT_EDITOR,
                'containerCssClass' => 'col-sm-12',
                'options' => [
                    'options' => ['rows' => 30]
                ]
            ]],
            'image' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-6',
                'temp' => MainController::$tempDir,
                'path' => CommentsController::$imageDir,
                'filesOptions' => CommentsController::$imageOptions,
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
                        'maxFileSize' => 2,
                    ],
                ]
            ],
            'video' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-6',
                'temp' => MainController::$tempDir,
                'path' => CommentsController::$videoDir,
                'filesOptions' => CommentsController::$videoOptions,
                'options' => [
                    'url' => Url::to(['upload-video']),
                    'removeUrl' => Url::to(['delete-video']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId(new self(), 'video')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود ویدیو کلیک کنید',
                        'acceptedFiles' => 'mp4',
                        'maxFiles' => 1,
                        'maxFileSize' => 50,
                    ],
                ]
            ]
        ]);
    }
}
