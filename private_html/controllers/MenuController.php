<?php

namespace app\controllers;

use app\components\CrudControllerInterface;
use app\components\CrudControllerTrait;
use app\models\Page;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use richardfan\sortable\SortableAction;
use Yii;
use app\models\Menu;
use app\models\MenuSearch;
use app\components\AuthController;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends AuthController
{
    use CrudControllerTrait;

    public static $imageDir = 'uploads/menu';
    public static $imageOptions = [];

    /**
     * @return string
     */
    public static function getModelName()
    {
        return  Menu::className();
    }

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
                'dir' => self::$imageDir,
                'options' => self::$imageOptions
            ]
        ];
    }

    public function actions()
    {
        return [
            'upload-image' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Menu(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Menu(),
                'attribute' => 'image',
                'upload' => self::$imageDir,
                'options' => self::$imageOptions
            ],
            'sort-item' => [
                'class' => SortableAction::className(),
                'activeRecordClassName' => Menu::className(),
                'orderColumn' => 'sort',
            ],
        ];
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $saveResult = false;
            $parentID = $model->parentID;
            if (empty($parentID)) {
                $saveResult = $model->makeRoot();
                $model->parentID = null;
            } else {
                $parent = Menu::findOne($parentID);
                $saveResult = $model->prependTo($parent);
            }
            if ($saveResult) {
                $this->saveUploaderAttributes($model);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => trans('words', 'base.successMsg')]);
                return $this->redirect(['index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $parent = $model->parents(1)->one();
        $children = $model->children()->all();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $oldUploaderValues = $this->getOldUploaderValues($model);
            $model->load(Yii::$app->request->post());

            $saveResult = false;
            $parentID = $model->parentID;
            if (empty($parentID)) {
                if ($parent)
                    $saveResult = $model->makeRoot();
                else
                    $saveResult = $model->save();
            } else {
                $newParent = Menu::findOne($parentID);
                $saveResult = $model->appendTo($newParent);
            }

            if ($saveResult) {
                $this->editUploaderAttributes($model, $oldUploaderValues);
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => trans('words', 'base.successMsg')]);
                return $this->redirect(['index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
        }
        if ($parent)
            $model->parentID = $parent->id;

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->deleteUploaderAttributes($model);
        $result = $model->deleteWithChildren();

        if ($result === false)
            Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => trans('words', 'base.deleteDangerMsg')]);
        else
            Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => trans('words', 'base.deleteSuccessMsg')]);


        return $this->redirect(['index']);
    }
}
