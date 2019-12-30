<?php

namespace app\models\blocks;

use app\components\MainController;
use app\controllers\BlockController;
use app\models\Block;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * This is the model class for table "item".
 *
 * @property string image
 * @property string link
 */
class Image extends Block
{
    public static $typeName = self::TYPE_IMAGE;

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'image' => ['CHAR', ''],
            'link' => ['CHAR', ''],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            ['image', 'required', 'except' => 'clone'],
            [['link'], 'string'],
            [['image'], 'safe'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'link' => trans('words', 'Link'),
            'image' => trans('words', 'Image')
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
                        'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg',
                        'maxFiles' => 30,
                        'maxFileSize' => 0.5,
                    ],
                ]
            ],
            'link' => [
                'type' => self::FORM_FIELD_TYPE_TEXT,
                'containerCssClass' => 'col-sm-12',
                'options' => ['dir' => 'auto']
            ],
        ]);
    }


    /**
     * @inheritDoc
     */
    public function render(View $view, $project)
    {
        return $view->render('//block/_image_view', ['block' => $this]);
    }
}