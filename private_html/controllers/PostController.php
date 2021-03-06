<?php

namespace app\controllers;

use app\components\CrudControllerInterface;
use app\components\CrudControllerTrait;
use app\components\Helper;
use app\models\Attachment;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use Yii;
use app\models\Post;
use app\models\PostSearch;
use app\components\AuthController;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends AuthController
{
    use CrudControllerTrait;

    public static $imageDir = 'uploads/post';
    public static $imageOptions = ['thumbnail' => ['width' => 100, 'height' => 100]];
    public static $galleryOptions = ['thumbnail' => ['width' => 100, 'height' => 100]];

    public function getMenuActions()
    {
        return [
                'news',
                'articles'
        ];
    }

    /**
     * for attributes that is need uploader processes
     * @return array
     */
    public function uploaderAttributes()
    {
        return [
            'image' => [
                'dir' => self::$imageDir,
                'options' => self::$imageOptions
            ],
            'page_image' => [
                'dir' => self::$imageDir,
                'options' => self::$imageOptions
            ]
        ];
    }

    public function getSystemActions()
    {
        return [
                'upload-image',
                'delete-image',
                'upload-page-image',
                'delete-page-image',
                'upload-attachment',
                'delete-attachment',
                'show',
                'news',
                'articles',
        ];
    }

    public function actions()
    {
        return [
                'upload-image' => [
                        'class' => UploadAction::className(),
                        'fileName' => Html::getInputName(new Post(), 'image'),
                        'rename' => UploadAction::RENAME_UNIQUE,
                        'validateOptions' => array(
                                'acceptedTypes' => array('png', 'jpg', 'jpeg')
                        )
                ],
                'delete-image' => [
                        'class' => RemoveAction::className(),
                        'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                        'model' => new Post(),
                        'attribute' => 'image',
                        'upload' => self::$imageDir,
                        'options' => self::$imageOptions
                ],
                'upload-page-image' => [
                        'class' => UploadAction::className(),
                        'fileName' => Html::getInputName(new Post(), 'page_image'),
                        'rename' => UploadAction::RENAME_UNIQUE,
                        'validateOptions' => array(
                                'acceptedTypes' => array('png', 'jpg', 'jpeg')
                        )
                ],
                'delete-page-image' => [
                        'class' => RemoveAction::className(),
                        'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                        'model' => new Post(),
                        'attribute' => 'page_image',
                        'upload' => self::$imageDir,
                        'options' => self::$imageOptions
                ],
                'upload-attachment' => [
                        'class' => UploadAction::className(),
                        'rename' => UploadAction::RENAME_UNIQUE,
                        'fileName' => Html::getInputName(new Post(), 'gallery'),
                        'validateOptions' => array(
                                'acceptedTypes' => array('png', 'jpg', 'jpeg')
                        )
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
     * Lists all Post models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);

        return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();

        if (Yii::$app->request->isAjax and !Yii::$app->request->isPjax) {
            $model->load(Yii::$app->request->post());
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if (Yii::$app->request->post()) {
            $model->load(Yii::$app->request->post());
            $gallery = new UploadedFiles($this->tmpDir, $model->gallery, self::$galleryOptions);
            if ($model->save()) {
                $this->saveUploaderAttributes($model);
                $gallery->move(Attachment::getAttachmentPath());
                Yii::$app->session->setFlash('alert',
                        ['type' => 'success', 'message' => trans('words', 'base.successMsg')]);
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('alert',
                        ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
            }
        }

        return $this->render('create', [
                'model' => $model,
        ]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
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

        $image = new UploadedFiles(self::$imageDir, $model->image, self::$imageOptions);
        $gallery = new UploadedFiles(Attachment::$attachmentPath, $model->gallery, self::$galleryOptions);

        if (Yii::$app->request->post()) {
            $oldUploaderValues = $this->getOldUploaderValues($model);
            $oldGallery = ArrayHelper::map($model->gallery, 'id', 'file');
            $model->load(Yii::$app->request->post());

            if ($model->save()) {
                $this->editUploaderAttributes($model, $oldUploaderValues);
                $gallery->updateAll($oldGallery, $model->gallery, $this->tmpDir,
                    Attachment::getAttachmentRelativePath());
                Yii::$app->session->setFlash('alert',
                    ['type' => 'success', 'message' => trans('words', 'base.successMsg')]);
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('alert',
                    ['type' => 'danger', 'message' => trans('words', 'base.dangerMsg')]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'image' => $image,
            'gallery' => $gallery,
        ]);
    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->deleteUploaderAttributes($model);
        $model->delete();

        return $this->redirect(['index']);
    }

    public function actionShow($id)
    {
        $this->setTheme('frontend', ['layout' => 'inner']);
        $model = $this->findModel($id);

        $model->scenario = 'increase_seen';
        $model->seen++;
        $model->save(false);

        $latestNews = Post::getLatestItems(10, $id);

        return $this->render('show', [
                'model' => $model,
                'latestNews' => $latestNews,
        ]);
    }

    public function actionNews()
    {
        $this->setTheme('frontend', ['layout' => 'inner']);

        $searchModel = new PostSearch();

        $searchModel->type = Post::TYPE_NEWS;
        $searchModel->status = Post::STATUS_PUBLISHED;
        if ($term = Yii::$app->request->getQueryParam('term')) {
            $searchModel->name = $term;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        return $this->render('news', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    public function actionArticles()
    {
        $this->setTheme('frontend', ['bodyClass' => 'innerPages']);
        $searchModel = new PostSearch();

        $searchModel->type = Post::TYPE_ARTICLE;
        $searchModel->status = Post::STATUS_PUBLISHED;
        if ($term = Yii::$app->request->getQueryParam('term')) {
            $searchModel->name = $term;
        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination = false;
        return $this->render('articles', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public static function getModelName()
    {
        return Post::className();
    }
}
