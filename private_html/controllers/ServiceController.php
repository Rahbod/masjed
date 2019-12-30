<?php

namespace app\controllers;

use app\components\CrudControllerTrait;
use app\models\Attachment;
use app\models\Item;
use app\models\Page;
use app\models\Project;
use app\models\Service;
use app\models\ServiceSearch;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use Yii;
use app\components\AuthController;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends AuthController
{
    use CrudControllerTrait;

    public static $imageDir = 'uploads/pages';
    public static $imageOptions = [];
    public static $galleryOptions = ['thumbnail' => ['width' => 200, 'height' => 200]];

    /**
     * @return string
     */
    public static function getModelName()
    {
        return Service::className();
    }

    public function getSystemActions()
    {
        return [
            'upload-image',
            'delete-image',
            'upload-attachment',
            'delete-attachment',
            'list',
            'show',
        ];
    }

    public function actions()
    {
        return [
            'upload-image' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Service(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Service(),
                'attribute' => 'image',
                'upload' => self::$imageDir,
                'options' => self::$imageOptions
            ],
            'upload-attachment' => [
                'class' => UploadAction::className(),
                'rename' => UploadAction::RENAME_UNIQUE,
                'model' => new Service(),
                'modelName' => 'Service'
            ],
            'delete-attachment' => [
                'class' => RemoveAction::className(),
                'upload' => Attachment::$attachmentPath,
                'storedMode' => RemoveAction::STORED_RECORD_MODE,
                'model' => new Attachment(),
                'attribute' => 'file',
                'options' => self::$galleryOptions
            ],
        ];
    }

    /**
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' Service.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Service();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $image = new UploadedFiles(self::$tempDir, $model->image, self::$imageOptions);
            $gallery = new UploadedFiles(self::$tempDir, $model->gallery, self::$galleryOptions);
            if ($model->save()) {
                $image->move(static::$imageDir);
                $gallery->move(Attachment::getAttachmentPath());
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => trans('words', 'base.successMsg')]);
                return $this->redirect(isset($_GET['return']) ? $_GET['return'] : ['index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' Service.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        $image = new UploadedFiles(static::$imageDir, $model->image, static::$imageOptions);
        $gallery = new UploadedFiles(Attachment::$attachmentPath, $model->attachments, static::$galleryOptions);

        if (Yii::$app->request->post()) {
            $oldImage = $model->image;
            $oldGallery = ArrayHelper::map($model->gallery, 'id', 'file');
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                $image->update($oldImage, $model->image, static::$tempDir);
                $gallery->updateAll($oldGallery, $model->gallery, static::$tempDir, Attachment::getAttachmentRelativePath());
                Yii::$app->session->setFlash('alert', ['type' => 'success', 'message' => Yii::t('words', 'base.successMsg')]);
                return $this->redirect(['index']);
            } else
                Yii::$app->session->setFlash('alert', ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
        }

        return $this->render('update', [
            'model' => $model,
            'image' => $image,
            'gallery' => $gallery,
        ]);
    }

    /**
     * Deletes an existing Service model.
     * If deletion is successful, the browser will be redirected to the 'index' Service.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $image = new UploadedFiles(static::$imageDir, $model->image, static::$imageOptions);
        $image->removeAll(true);
        $gallery = new UploadedFiles(Attachment::$attachmentPath, $model->attachments, static::$galleryOptions);
        $gallery->removeAll(true);
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionList()
    {
        $this->setTheme('frontend');
        $this->innerPage = true;
        $this->bodyClass = 'text-page';
        $this->headerClass = 'header-style-2';
        $this->mainTag = 'main-text-page';

        $searchModel = new ServiceSearch();
        $dataProvider = $searchModel->search(request()->getQueryParams());

        return $this->render('list', compact('searchModel', 'dataProvider'));
    }

    public function actionShow($id)
    {
        $this->setTheme('frontend');
        $this->innerPage = true;

        $this->bodyClass = 'text-page more-one list';
        $this->headerClass = 'header-style-2';
        $this->mainTag = 'main-text-page';

        $model = $this->findModel($id);
        $model->scenario = 'increase_seen';
        $model->seen++;
        $model->save(false);

        $availableProjects = Project::find()->andWhere(['>', Project::columnGetString('free_count'), 0])->all();
        return $this->render('show', [
            'model' => $model,
            'availableProjects' => $availableProjects,
        ]);
    }
}