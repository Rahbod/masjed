<?php

namespace app\controllers;

use Yii;
use app\models\ProjectTimeline;
use app\models\ProjectTimelineSearch;
use app\components\AuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\components\CrudControllerTrait;
use app\components\CrudControllerInterface;

/**
 * TimelineController implements the CRUD actions for ProjectTimeline model.
 */
class TimelineController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait;

    public $indexTitle = 'Project Timeline';
    public $createTitle = 'Create Timeline';
    public $updateTitle = 'Update Timeline: {name}';
    public $viewTitle = 'View Timeline: {name}';

    /**
    * @return string
    */
    public function getModelName()
    {
        return ProjectTimeline::className();
    }

    public function getViewPath()
    {
        return '@app/views/layouts/default_crud';
    }
}
