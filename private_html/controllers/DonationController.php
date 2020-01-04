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

/**
 * DonationController implements the CRUD actions for Donation model.
 */
class DonationController extends AuthController
{
    use CrudControllerTrait;

    /**
    * @return string
    */
    public function getModelName()
    {
        return Donation::className();
    }
}
