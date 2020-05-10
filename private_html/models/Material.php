<?php

namespace app\models;

use app\components\MainController;
use app\controllers\MaterialController;
use app\controllers\SectionController;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 *
 * @property string $description
 * @property string $ar_description
 * @property string $en_description
 * @property string $body
 * @property string $ar_body
 * @property string $en_body
 * @property string $icon
 * @property string $image
 * @property string $required_amount
 * @property string $ar_required_amount
 * @property string $en_required_amount
 * @property string $submitted_amount
 * @property string $ar_submitted_amount
 * @property string $en_submitted_amount
 */
class Material extends Item
{
    public static $multiLanguage = false;
    public static $modelName = 'material';

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
                'description' => ['CHAR', ''],
                'ar_description' => ['CHAR', ''],
                'en_description' => ['CHAR', ''],

                'body' => ['CHAR', ''],
                'ar_body' => ['CHAR', ''],
                'en_body' => ['CHAR', ''],


                'required_amount' => ['CHAR', ''],
                'ar_required_amount' => ['CHAR', ''],
                'en_required_amount' => ['CHAR', ''],

                'submitted_amount' => ['CHAR', ''],
                'ar_submitted_amount' => ['CHAR', ''],
                'en_submitted_amount' => ['CHAR', ''],

                'icon' => ['CHAR', ''],
                'image' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function formAttributes()
    {
        return array_merge(parent::formAttributes(),[
                [['description', 'ar_description', 'en_description'], self::FORM_FIELD_TYPE_TEXT_AREA],
                [
                        [
                                'required_amount',
                                'ar_required_amount',
                                'en_required_amount',
                            //
                                'submitted_amount',
                                'ar_submitted_amount',
                                'en_submitted_amount'
                        ],
                        self::FORM_FIELD_TYPE_TEXT
                ],
                [
                        ['body', 'ar_body', 'en_body'],
                        [
                                'type' => self::FORM_FIELD_TYPE_TEXT_EDITOR,
                                'containerCssClass' => 'col-sm-12',
                                'options' => [
                                        'options' => ['rows' => 30]
                                ]
                        ]
                ],
                'icon' => [
                        'type' => self::FORM_FIELD_TYPE_DROP_ZONE,
                        'hint' => 'تصویر آیکون با فرمت png یا svg',
                        'containerCssClass' => 'col-sm-4',
                        'temp' => MainController::$tempDir,
                        'path' => MaterialController::$iconDir,
                        'filesOptions' => MaterialController::$iconOptions,
                        'options' => [
                                'url' => Url::to(['upload-icon']),
                                'removeUrl' => Url::to(['delete-icon']),
                                'sortable' => false, // sortable flag
                                'sortableOptions' => [], // sortable options
                                'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'icon')],
                                'options' => [
                                        'createImageThumbnails' => true,
                                        'addRemoveLinks' => true,
                                        'dictRemoveFile' => 'حذف',
                                        'addViewLinks' => true,
                                        'dictViewFile' => '',
                                        'dictDefaultMessage' => 'جهت آپلود آیکون کلیک کنید',
                                        'acceptedFiles' => 'svg, png',
                                        'maxFiles' => 1,
                                        'maxFileSize' => 0.5,
                                ],
                        ]
                ],

                'image' => [
                        'type' => self::FORM_FIELD_TYPE_DROP_ZONE,
                        'hint' => 'تصویر آیکون با فرمت svg',
                        'containerCssClass' => 'col-sm-4',
                        'temp' => MainController::$tempDir,
                        'path' => MaterialController::$iconDir,
                        'filesOptions' => MaterialController::$iconOptions,
                        'options' => [
                                'url' => Url::to(['upload-icon']),
                                'removeUrl' => Url::to(['delete-icon']),
                                'sortable' => false, // sortable flag
                                'sortableOptions' => [], // sortable options
                                'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'icon')],
                                'options' => [
                                        'createImageThumbnails' => true,
                                        'addRemoveLinks' => true,
                                        'dictRemoveFile' => 'حذف',
                                        'addViewLinks' => true,
                                        'dictViewFile' => '',
                                        'dictDefaultMessage' => 'جهت آپلود آیکون کلیک کنید',
                                        'acceptedFiles' => 'svg',
                                        'maxFiles' => 1,
                                        'maxFileSize' => 0.5,
                                ],
                        ]
                ],
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
                                'description',
                                'ar_description',
                                'en_description',
                                'body',
                                'ar_body',
                                'en_body',
                                'required_amount',
                                'ar_required_amount',
                                'en_required_amount',
                                'submitted_amount',
                                'ar_submitted_amount',
                                'en_submitted_amount',
                                'icon',
                                'image'
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
                'description' => trans('words', 'Description'),
                'ar_description' => trans('words', 'Ar Description'),
                'en_description' => trans('words', 'En Description'),
                'body' => trans('words', 'Body'),
                'ar_body' => trans('words', 'Ar Body'),
                'en_body' => trans('words', 'En Body'),
                'required_amount' => trans('words', 'Required Amount'),
                'ar_required_amount' => trans('words', 'Ar Required Amount'),
                'en_required_amount' => trans('words', 'En Required Amount'),
                'submitted_amount' => trans('words', 'Submitted Amount'),
                'ar_submitted_amount' => trans('words', 'Ar Submitted Amount'),
                'en_submitted_amount' => trans('words', 'En Submitted Amount'),
                'icon' => trans('words', 'Icon'),
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

    public function getIconSrc()
    {
        $path = Yii::$app->request->getBaseUrl();
        return $path . '/' . MaterialController::$iconDir . '/' . $this->icon;
    }

    public function getImageSrc()
    {
        $path = Yii::$app->request->getBaseUrl();
        return $path . '/' . MaterialController::$iconDir . '/' . $this->image;
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

    public function getRequiredAmountStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa') {
                return $this->required_amount;
            } else {
                return $this->{Yii::$app->language . '_required_amount'} ?: $this->required_amount;
            }
        }
        return $this->required_amount;
    }

    public function getSubmittedAmountStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa') {
                return $this->submitted_amount;
            } else {
                return $this->{Yii::$app->language . '_submitted_amount'} ?: $this->submitted_amount;
            }
        }
        return $this->submitted_amount;
    }

    public function getMoreUrl()
    {
        return Url::to(['/material/show', 'id' => $this->id]);
    }
}
