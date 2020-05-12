<?php

namespace app\models;

use app\components\customWidgets\CustomActionColumn;
use app\components\MainController;
use app\controllers\MaterialController;
use app\controllers\SectionController;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * This is the model class for table "item".
 *
 * @property string $icon
 * @property string $icon_hover
 * @property string $image
 * @property string $description
 * @property string $ar_description
 * @property string $en_description
 * @property string $body
 * @property string $ar_body
 * @property string $en_body
 *
 * @property Page $page
 */
class ProjectSection extends Item
{
    public static $multiLanguage = false;
    public static $modelName = 'project-section';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @param int $limit
     * @param string $orderBy
     * @return ProjectSection[]
     */
    public static function getLastRows($limit = 4, $orderBy = 'id')
    {
        $query = self::find();

        $query->from('(SELECT * FROM ' . self::tableName() . ' ORDER BY ' . $orderBy . ' DESC LIMIT ' . $limit . ') as t')
                ->orderBy([$orderBy => SORT_ASC]);

        return $query->all();
    }

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

                'icon' => ['CHAR', ''],
                'icon_hover' => ['CHAR', ''],
                'image' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function formAttributes()
    {
        return array_merge(parent::formAttributes(), [
                [['description', 'ar_description', 'en_description'], self::FORM_FIELD_TYPE_TEXT_AREA],
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
                        'hint' => 'تصویر آیکون با فرمت svg',
                        'containerCssClass' => 'col-sm-4',
                        'temp' => MainController::$tempDir,
                        'path' => SectionController::$iconDir,
                        'filesOptions' => SectionController::$iconOptions,
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
                'icon_hover' => [
                        'type' => self::FORM_FIELD_TYPE_DROP_ZONE,
                        'hint' => 'تصویر آیکون hover با فرمت svg',
                        'containerCssClass' => 'col-sm-4',
                        'temp' => MainController::$tempDir,
                        'path' => SectionController::$iconDir,
                        'filesOptions' => SectionController::$iconOptions,
                        'options' => [
                                'url' => Url::to(['upload-icon-hover']),
                                'removeUrl' => Url::to(['delete-icon-hover']),
                                'sortable' => false, // sortable flag
                                'sortableOptions' => [], // sortable options
                                'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'icon_hover')],
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

                'image' => [
                        'type' => self::FORM_FIELD_TYPE_DROP_ZONE,
                        'hint' => 'تصویر بزرگ',
                        'containerCssClass' => 'col-sm-4',
                        'temp' => MainController::$tempDir,
                        'path' => SectionController::$imageDir,
                        'filesOptions' => SectionController::$imageOptions,
                        'options' => [
                                'url' => Url::to(['upload-image']),
                                'removeUrl' => Url::to(['delete-image']),
                                'sortable' => false, // sortable flag
                                'sortableOptions' => [], // sortable options
                                'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'image')],
                                'options' => [
                                        'createImageThumbnails' => true,
                                        'addRemoveLinks' => true,
                                        'dictRemoveFile' => 'حذف',
                                        'addViewLinks' => true,
                                        'dictViewFile' => '',
                                        'dictDefaultMessage' => 'جهت آپلود آیکون کلیک کنید',
                                        'acceptedFiles' => 'png, jpg, jpeg',
                                        'maxFiles' => 1,
                                        'maxFileSize' => 5,
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
//                [['icon','image'], 'required'],
                [['icon','icon_hover','image'], 'string'],
                [['description', 'ar_description', 'en_description'], 'string'],
                [['body', 'ar_body', 'en_body'], 'string'],
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
                'icon' => trans('words', 'Icon'),
                'icon_hover' => trans('words', 'Icon Hover'),
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

    public function tableColumns()
    {
        return [
                'name',
                ['class' => CustomActionColumn::className()]
        ];
    }

    public function getIconSrc()
    {
        if(is_file(alias('@webroot').DIRECTORY_SEPARATOR.SectionController::$iconDir.DIRECTORY_SEPARATOR.$this->icon)) {
            $path = Yii::$app->request->getBaseUrl();
            return $path . '/' . SectionController::$iconDir . '/' . $this->icon;
        }
        return null;
    }

    public function getIconHoverSrc()
    {
        if(is_file(alias('@webroot').DIRECTORY_SEPARATOR.SectionController::$iconDir.DIRECTORY_SEPARATOR.$this->icon_hover)) {
            $path = Yii::$app->request->getBaseUrl();
            return $path . '/' . SectionController::$iconDir . '/' . $this->icon_hover;
        }
        return $this->getIconSrc();
    }

    public function getImageSrc()
    {
        if(is_file(alias('@webroot').DIRECTORY_SEPARATOR.SectionController::$imageDir.DIRECTORY_SEPARATOR.$this->image)) {
            $path = Yii::$app->request->getBaseUrl();
            return $path . '/' . SectionController::$imageDir . '/' . $this->image;
        }
        return null;
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

    public function getMoreUrl()
    {
        return Url::to(['/section/show', 'id' => $this->id]);
    }

    public function getModelImage()
    {
        return $this->getImageSrc();
    }
}