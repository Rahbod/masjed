<?php

namespace app\controllers;

use Yii;
use app\models\Donation;
use app\models\DonationSearch;
use app\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\components\CrudControllerTrait;
use app\components\CrudControllerInterface;

/**
 * DonationController implements the CRUD actions for Donation model.
 */
class DonationController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait;

    /**
    * @return string
    */
    public function getModelName()
    {
        return Donation::className();
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
