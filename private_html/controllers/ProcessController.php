<?php

namespace app\controllers;

use app\components\Setting;
use app\models\Page;
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
     * Lists all Slide models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModelName = $this->getModelName() . "Search";
        $searchModel = new $searchModelName();

        $dataProvider = $searchModel->search(app()->request->queryParams);

        return $this->render('/process/index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSaveMore()
    {
        if ($page_id = request()->post('page_id')) {
            if ($page = Page::findOne($page_id)) {
                Setting::set(ProjectProcess::$morePageSettingKey, $page_id);
            }
        }

        return $this->redirect(['index']);
    }

    public function actionArchive($id = false)
    {
        $this->setTheme('frontend', ['layout' => 'inner']);
        $processes = ProjectProcess::find()->valid()->all();

        return $this->render('/process/archive', compact('processes','id'));
    }
}
