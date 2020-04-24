<?php

namespace app\controllers;

use Yii;
use app\models\ProjectProcess;
use app\models\ProjectProcessSearch;
use app\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\components\CrudControllerTrait;
use app\components\CrudControllerInterface;

/**
 * ProcessController implements the CRUD actions for ProjectProcess model.
 */
class ProcessController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait;

    public $indexTitle = 'Project Process';
    public $createTitle = 'Create Process';
    public $updateTitle = 'Update Process: {name}';
    public $viewTitle = 'View Process: {name}';

    /**
    * @return string
    */
    public function getModelName()
    {
        return ProjectProcess::className();
    }

    public function getViewPath()
    {
        return '@app/views/layouts/default_crud';
    }

    /**
    * for attributes that is need uploader processes
    * @return array
    */
    /*public function uploaderAttributes()
    {
        return [
            'image' => [
                'dir' => self::$imgDir,
                'options' => self::$imageOptions
            ]
        ];
    }*/
}
