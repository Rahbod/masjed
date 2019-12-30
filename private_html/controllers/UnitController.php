<?php

namespace app\controllers;

use app\components\CrudControllerTrait;
use app\models\Block;
use app\models\Project;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use Yii;
use app\models\Unit;
use app\models\UnitSearch;
use app\components\AuthController;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class UnitController extends AuthController
{
    use CrudControllerTrait;

    public static $imgDir = 'uploads/unit';
    public static $imageOptions = ['thumbnail' => ['width' => 260, 'height' => 130]];

    public function getModelName()
    {
        return Unit::className();
    }

    public function getSystemActions()
    {
        return ['show'];
    }

    public function uploaderAttributes()
    {
        return ['image' => ['dir' => self::$imgDir, 'options' => self::$imageOptions]];
    }

    public function actions()
    {
        return [
            'upload-image' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Unit(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'upload' => self::$imgDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Unit(),
                'attribute' => 'image',
                'options' => static::$imageOptions
            ],
        ];
    }

    /**
     * Lists all Unit models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        app()->session->set('itemID', $id);

        $searchModel = new UnitSearch();
        $searchModel->itemID = $id;
        $dataProvider = $searchModel->search(app()->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Unit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
//        dd(app()->request);

        $model = new Unit();
        $model->itemID = app()->session->get('itemID');

        if (app()->request->isAjax and !app()->request->isPjax) {
            $model->load(app()->request->post());
            app()->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (app()->request->post()) {
            $model->load(app()->request->post());
            if ($model->save()) {
                $this->saveUploaderAttributes($model);
                app()->session->setFlash('alert', ['type' => 'success', 'message' => trans('words', 'base.successMsg')]);
                return $this->redirect(['index', 'id' => $model->itemID]);
            } else
                app()->session->setFlash('alert', ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Unit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (app()->request->isAjax and !app()->request->isPjax) {
            $model->load(app()->request->post());
            app()->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (app()->request->post()) {
            $oldUploaderValues = $this->getOldUploaderValues($model);
            $model->load(app()->request->post());
            if ($model->save()) {
                $this->editUploaderAttributes($model, $oldUploaderValues);
                app()->session->setFlash('alert', ['type' => 'success', 'message' => trans('words', 'base.successMsg')]);
                return $this->redirect(['index', 'id' => $model->itemID]);
            } else
                app()->session->setFlash('alert', ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->deleteUploaderAttributes($model);
        $model->delete();

        return $this->redirect(['index', 'id' => $model->itemID]);
    }


    public function actionShow($id)
    {
        $this->setTheme('frontend');
        $this->innerPage = true;
        $this->bodyClass = 'final-project-view special';

        $model = $this->findModel($id);

        $this->submenu = [
            'gallery' => $model->hasBlock(Block::TYPE_GALLERY),
            'video' => $model->hasBlock(Block::TYPE_VIDEO),
            'unit' => true,
            'map' => $model->hasBlock(Block::TYPE_MAP_VIEW),
            'nearby' => $model->hasBlock(Block::TYPE_NEARBY_ACCESS),
            'contact' => $model->hasBlock(Block::TYPE_CONTACT),
        ];

        return $this->render('show', compact('model'));
    }
}
