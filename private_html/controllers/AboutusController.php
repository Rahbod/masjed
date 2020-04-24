<?php

namespace app\controllers;

use Yii;
use app\models\Aboutus;
use app\models\AboutusSearch;
use app\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\components\CrudControllerTrait;
use app\components\CrudControllerInterface;

/**
 * AboutusController implements the CRUD actions for Aboutus model.
 */
class AboutusController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait;

    /**
    * @return string
    */
    public function getModelName()
    {
        return Aboutus::className();
    }

    public function getViewPath()
    {
        return '@app/views/layouts/default_crud';
    }
}
