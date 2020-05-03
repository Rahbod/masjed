<?php

namespace app\controllers;

use app\models\Material;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use app\components\AuthController;
use yii\helpers\Html;
use app\components\CrudControllerTrait;
use app\components\CrudControllerInterface;

/**
 * MaterialController implements the CRUD actions for Material model.
 */
class MaterialController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait;

    public $indexTitle = 'Material Assistance';
    public $createTitle = 'Create New';
    public $updateTitle = 'Update Material: {name}';
    public $viewTitle = 'View Material: {name}';

    public static $iconDir = 'uploads/project/material';
    public static $iconOptions = [];
    public static $imageOptions = [];

    /**
     * @return string
     */
    public function getModelName()
    {
        return Material::className();
    }

    public function getViewPath()
    {
        return '@app/views/layouts/default_crud';
    }

    public function getSystemActions()
    {
        return [
                'upload-icon',
                'delete-icon',
                'upload-image',
                'delete-image',
                'archive',
        ];
    }

    public function uploaderAttributes()
    {
        return [
                'icon' => ['dir' => self::$iconDir, 'options' => self::$iconOptions],
                'image' => ['dir' => self::$iconDir, 'options' => self::$imageOptions],
        ];
    }

    public function actions()
    {
        return [
                'upload-icon' => [
                        'class' => UploadAction::className(),
                        'fileName' => Html::getInputName(new Material(), 'icon'),
                        'rename' => UploadAction::RENAME_UNIQUE,
                        'validateOptions' => array(
                                'acceptedTypes' => array('svg', 'png')
                        )
                ],
                'delete-icon' => [
                        'class' => RemoveAction::className(),
                        'upload' => self::$iconDir,
                        'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                        'model' => new Material(),
                        'attribute' => 'icon',
                        'options' => static::$iconOptions
                ],
                'upload-image' => [
                        'class' => UploadAction::className(),
                        'fileName' => Html::getInputName(new Material(), 'image'),
                        'rename' => UploadAction::RENAME_UNIQUE,
                        'validateOptions' => array(
                                'acceptedTypes' => array('png', 'jpg', 'jpeg')
                        )
                ],
                'delete-image' => [
                        'class' => RemoveAction::className(),
                        'upload' => self::$iconDir,
                        'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                        'model' => new Material(),
                        'attribute' => 'image',
                        'options' => static::$imageOptions
                ],
        ];
    }

    public function actionArchive()
    {
        $this->setTheme('frontend', ['layout' => 'inner']);
        $materials = Material::find()->valid()->all();

        return $this->render('/material/archive', compact('materials'));
    }
}