<?php

namespace app\controllers;

use app\components\CrudControllerInterface;
use Yii;
use app\components\CrudControllerTrait;
use app\components\Setting;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use app\models\Slide;
use app\components\AuthController;
use yii\helpers\Html;

/**
 * SlideController implements the CRUD actions for Slide model.
 */
class SlideController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait; // add crud functions [index, create, update, delete]

    /**
     * @inheritDoc
     */
    public static function getModelName()
    {
        return  Slide::className();
    }

    /**
     * @inheritDoc
     */
    public static function getRoutes()
    {
        return [
            static::AFTER_SAVE_ROUTE => 'index'
        ];
    }

    public static $imgDir = 'uploads/slide';
    public static $imageOptions = [];

    public function getSystemActions()
    {
        return [
            'upload-image',
            'delete-image',
        ];
    }

    public function uploaderAttributes()
    {
        return [
            'image' => [
                'dir' => static::$imgDir,
                'options' => static::$imageOptions,
            ]
        ];
    }

    public function actions()
    {
        return [
            'upload-image' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Slide(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Slide(),
                'attribute' => 'image',
                'upload' => static::$imgDir
            ]
        ];
    }

    public function actionSetting()
    {
        if (app()->request->post()) {
            $postData = app()->request->post('Setting');

            ## region validation post data
            $config = Setting::getAll();
            ## endregion validation post data

            Setting::createOrUpdateDefaults($config);
            $config['slider'] = $postData;

            if (Setting::setAll($config)) {
                \Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => \trans('words', 'base.successMsg')]);
                return $this->refresh();
            } else
                \Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => \trans('words', 'base.dangerMsg')]);
        }

        return $this->render('setting');
    }
}
