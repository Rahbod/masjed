<?php

namespace app\models\blocks;

use app\components\MainController;
use app\controllers\BlockController;
use app\models\Block;
use app\models\Project;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * This is the model class for table "item".
 *
 * @property string image
 * @property string location_link
 */
class Map extends Block
{
    public static $typeName = self::TYPE_MAP_VIEW;

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'image' => ['CHAR', ''],
            'location_link' => ['CHAR', '']
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            [['location_link','image'], 'required', 'except' => 'clone'],
            ['location_link', 'string'],
            ['image', 'string'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'image' => trans('words', 'Image'),
            'location_link' => trans('words', 'Location link')
        ]);
    }

    public function formAttributes()
    {
        return array_merge(parent::formAttributes(),[
            'image' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-12',
                'temp' => MainController::$tempDir,
                'path' => BlockController::$imgDir,
                'filesOptions' => BlockController::$imageOptions,
                'hint' => 'حداقل عرض تصویر: 1920 پیکسل',
                'options' => [
                    'name' => Html::getInputName(new Block(), 'image'),
                    'url' => Url::to(['upload-image']),
                    'removeUrl' => Url::to(['delete-image']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new Block(), 'image')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود نقشه تصویر کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg',
                        'maxFiles' => 1,
                        'maxFileSize' => 0.5,
                    ],
                ]
            ],
           'location_link'=>self::FORM_FIELD_TYPE_TEXT
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render(View $view, $project)
    {
        /** @var $project Project */
        return $view->render('//block/_map_view', ['block' => $this]);
    }
}