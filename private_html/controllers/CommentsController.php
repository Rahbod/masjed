<?php

namespace app\controllers;

use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use app\models\Comments;
use app\components\AuthController;
use yii\helpers\Html;
use app\components\CrudControllerTrait;
use app\components\CrudControllerInterface;

/**
 * CommentsController implements the CRUD actions for Comments model.
 */
class CommentsController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait;

    public $indexTitle = 'Comments';
    public $createTitle = 'Create Comment';
    public $updateTitle = 'Update Comment: {name}';
    public $viewTitle = 'View Comment: {name}';

    public static $imageDir = 'uploads/comments';
    public static $imageOptions = [];
    public static $videoDir = 'uploads/comments/video';
    public static $videoOptions = [];

    /**
    * @return string
    */
    public function getModelName()
    {
        return Comments::className();
    }

    public function getViewPath()
    {
        return '@app/views/layouts/default_crud';
    }

    public function getSystemActions()
    {
        return [
                'upload-video', 'delete-video', 'upload-image', 'delete-image'
        ];
    }

    /**
    * for attributes that is need uploader processes
    * @return array
    */
    public function uploaderAttributes()
    {
        return [
            'image' => [
                'dir' => self::$imageDir,
                'options' => self::$imageOptions
            ],
            'video' => [
                'dir' => self::$videoDir,
                'options' => self::$videoOptions
            ]
        ];
    }

    public function actions()
    {
        return [
                'upload-video' => [
                        'class' => UploadAction::className(),
                        'fileName' => Html::getInputName(new Comments(), 'video'),
                        'rename' => UploadAction::RENAME_UNIQUE,
                        'validateOptions' => array(
                                'acceptedTypes' => array('mp4')
                        )
                ],
                'delete-video' => [
                        'class' => RemoveAction::className(),
                        'upload' => self::$videoDir,
                        'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                        'model' => new Comments(),
                        'attribute' => 'video',
                        'options' => static::$videoOptions
                ],

                'upload-image' => [
                        'class' => UploadAction::className(),
                        'fileName' => Html::getInputName(new Comments(), 'image'),
                        'rename' => UploadAction::RENAME_UNIQUE,
                        'validateOptions' => array(
                                'acceptedTypes' => array('png', 'jpg', 'jpeg')
                        )
                ],
                'delete-image' => [
                        'class' => RemoveAction::className(),
                        'upload' => self::$imageDir,
                        'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                        'model' => new Comments(),
                        'attribute' => 'image',
                        'options' => static::$imageOptions
                ],
        ];
    }
}