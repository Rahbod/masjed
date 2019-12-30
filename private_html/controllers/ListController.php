<?php

namespace app\controllers;

use app\components\CrudControllerInterface;
use app\models\Lists;
use app\models\ListsSearch;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use app\components\CrudControllerTrait;
use app\components\Setting;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use app\models\Slide;
use app\components\AuthController;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ListController implements the CRUD actions for Slide model.
 */
class ListController extends AuthController implements CrudControllerInterface
{
    use CrudControllerTrait; // add crud functions [index, create, update, delete]

    /**
     * @inheritDoc
     */
    public static function getModelName()
    {
        return Lists::className();
    }


    /**
     * Creates a new Lists model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Lists();

        if ($slug = request()->getQueryParam('slug')) {
            if (app()->session->get('slug') != $slug)
                app()->session->set('return', request()->referrer);
            app()->session->set('slug', $slug);

            if ($list = Lists::find()->andWhere([Lists::columnGetString('slug') => $slug])->one())
                return $this->redirect(['options', 'id' => $list->id]);
            $model->name = request()->getQueryParam('label')?:$slug;
            $model->slug = $slug;
            if($model->makeRoot())
                return $this->redirect(['options', 'id' => $model->id]);
        }

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            if ($model->load(Yii::$app->request->post()) && ($saveResult = $model->makeRoot())) {
                Yii::$app->session->setFlash('public-alert', ['type' => 'success', 'message' => 'اطلاعات با موفقیت ثبت شد.']);
                return $this->redirect(['index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => 'در ثبت اطلاعات خطایی رخ داده است.']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Lists model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        /** @var Lists $model */
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('public-alert', ['type' => 'success', 'message' => 'اطلاعات با موفقیت ثبت شد.']);
                return $this->redirect(['index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => 'در ثبت اطلاعات خطایی رخ داده است.']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

//    public function actionDelete($id)
//    {
//        /** @var NestedSetsBehavior $model */
//        $model = Lists::findOne($id);
//        $model->deleteWithChildren();
//    }

    /**
     * Lists all list options models.
     * @param integer $id
     * @return mixed
     */
    public function actionOptions($id)
    {
        $model = $this->findModel($id);

        $searchModel = new ListsSearch();
        $searchModel->parentID = $id;
        $options = $searchModel->search(request()->getQueryParams());

        return $this->render('options', [
            'model' => $model,
            'dataProvider' => $options,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new Lists model (option).
     * @param integer $id
     * @return mixed
     */
    public function actionAddOption($id)
    {
        $model = new Lists();
        $parent = $this->findModel($id);
        $model->scenario = 'option-insert';

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post())) {
                $model->parentID = $id;
                $model->status = 1;

                if ($model->prependTo($parent)) {
                    app()->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                    return $this->redirect(['options', 'id' => $id]);
                } else
                    app()->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
            } else
                app()->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('option_create', [
            'model' => $model,
            'parent' => $parent,
        ]);
    }

    /**
     * Updates an existing Lists model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateOption($id)
    {
        $model = $this->findModel($id);
        $parent = $this->findModel($model->parentID);
        $model->scenario = 'option-update';

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                app()->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['options', 'id' => $parent->id]);
            } else
                app()->session->setFlash('alert', ['type' => 'danger', 'message' => Yii::t('words', 'base.dangerMsg')]);
        }

        return $this->render('option_update', [
            'model' => $model,
            'parent' => $parent,
        ]);
    }

    /**
     * Deletes an existing Lists model.
     * @return mixed
     */
    public function actionDeleteOption($id)
    {
        $model = $this->findModel($id);
        $model->delete();
        return $this->redirect(['index', 'id' => $model->parentID]);
    }
}