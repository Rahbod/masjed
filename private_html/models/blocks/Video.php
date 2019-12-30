<?php

namespace app\models\blocks;

use app\components\MainController;
use app\controllers\BlockController;
use app\models\Block;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * This is the model class for table "item".
 *
 * @property string link
 * @property string video
 * @property string image
 * @property string poster
 */
class Video extends Block
{
    public static $typeName = self::TYPE_VIDEO;

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'link' => ['CHAR', ''],

            'image' => ['CHAR', ''],
            'video' => ['CHAR', ''],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            [['link', 'video', 'image'], 'string'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'link' => trans('words', 'Embed code'),
            'video' => trans('words', 'Video file'),
            'image' => trans('words', 'Poster'),
        ]);
    }

    public function formAttributes()
    {
        return array_merge(parent::formAttributes(), [
            'link' => [
                'type' => self::FORM_FIELD_TYPE_TEXT_AREA,
                'containerCssClass' => 'col-sm-12',
                'hint' => "اسکریپت ویدئو را میتوانید از سایت های آپارت و ... دریافت کرده و در این قسمت کپی کنید.\nبه طور همزمان فقط یکی از حالت های اسکریپت یا فایل ویدئو نمایش داده میشود.",
                'options' => ['dir' => 'auto']
            ],
            'image' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-6',
                'temp' => MainController::$tempDir,
                'path' => BlockController::$imgDir,
                'filesOptions' => BlockController::$imageOptions,
                'hint' => 'حداقل سایز پوستر ویدئو: 1920 در 1080 پیکسل',
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
                        'dictDefaultMessage' => 'جهت آپلود پوستر ویدئو کلیک کنید',
                        'acceptedFiles' => 'png, jpg, jpeg',
                        'maxFiles' => 1,
                        'maxFileSize' => 0.5,
                    ],
                ]
            ],
            'video' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-6',
                'temp' => MainController::$tempDir,
                'path' => BlockController::$videoDir,
                'filesOptions' => [],
                'options' => [
                    'name' => Html::getInputName(new Block(), 'video'),
                    'url' => Url::to(['upload-video']),
                    'removeUrl' => Url::to(['delete-video']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new Block(), 'video')],
                    'options' => [
                        'createImageThumbnails' => false,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود ویدئو کلیک کنید',
                        'acceptedFiles' => 'mp4',
                        'maxFiles' => 1,
                        'maxFileSize' => 200,
                    ],
                ]
            ],
        ]);
    }

    public function getContent()
    {
        if (!empty($this->link))
            return $this->link;

        $videoUrl = alias('@web').'/'.BlockController::$videoDir.'/'.$this->video;
        $posterUrl = alias('@web').'/'.BlockController::$imgDir.'/'.$this->image;
        return Html::tag('video', Html::tag('source','',['src' => $videoUrl, 'type' => 'video/mp4']),[
            'controls' => true,
            'poster' => $posterUrl,
            'preload' => 'none'
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render(View $view, $project)
    {
        return $view->render('//block/_video_view', ['block' => $this]);
    }
}