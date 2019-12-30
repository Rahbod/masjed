<?php

namespace app\controllers;

use app\components\AuthController;
use app\components\CrudControllerTrait;
use app\models\Block;
use app\models\Page;
use app\models\Project;
use app\models\ProjectSearch;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use devgroup\dropzone\UploadedFiles;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends AuthController
{
    use CrudControllerTrait;

    public static $imgDir = 'uploads/project';
    public static $pdfDir = 'uploads/project/pdf';

    public static $imageOptions = ['thumbnail' => [
        'width' => 100,
        'height' => 100
    ]];

    /**
     * @return string
     */
    public function getModelName()
    {
        return Project::className();
    }

    public function getSystemActions()
    {
        return ['list', 'show'];
    }

    public function getMenuActions()
    {
        return ['list'];
    }

    public function uploaderAttributes()
    {
        return [
            'image' => [
                'dir' => self::$imgDir,
                'options' => self::$imageOptions
            ],
            'banner' => [
                'dir' => self::$imgDir,
                'options' => []
            ],
            'pdf_file' => [
                'dir' => self::$pdfDir,
                'options' => []
            ]
        ];
    }

    public function actions()
    {
        return [
            'upload-image' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Project(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'upload' => self::$imgDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Project(),
                'attribute' => 'image',
                'options' => static::$imageOptions
            ],
            'upload-banner' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Project(), 'banner'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-banner' => [
                'class' => RemoveAction::className(),
                'upload' => self::$imgDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Project(),
                'attribute' => 'banner',
                'options' => []
            ],
            'upload-pdf' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Project(), 'pdf_file'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('pdf')
                )
            ],
            'delete-pdf' => [
                'class' => RemoveAction::className(),
                'upload' => self::$pdfDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Project(),
                'attribute' => 'pdf_file',
                'options' => []
            ],
        ];
    }

    // ----------------rezvan methods ------------------
    public function actionList()
    {
        $this->setTheme('frontend');

        $this->innerPage = true;
        $this->bodyClass = 'more-one list';

        /** @var Project[] $projects */
        $projects = Project::find()->orderBy([
            'id' => SORT_DESC,
        ])->all();

        $availableProjects = Project::find()->andWhere(['>', Project::columnGetString('free_count'), 0])->count();

        return $this->render('list', [
            'projects' => $projects,
            'availableProjects' => $availableProjects,
        ]);
    }

    public function actionShow($id)
    {
        $this->setTheme('frontend');
        $this->innerPage = true;

        /** @var Project $model */
        $model = $this->findModel($id);

        if ($model->project_type == Project::SINGLE_VIEW) {
            $this->bodyClass = 'final-project-view';
            $this->breadcrumbs = [
                trans('words', 'Available Projects'),
                $model->getName(),
                $model->getSubtitleStr(),
            ];

            $this->submenu = [
                'gallery' => $model->hasBlock(Block::TYPE_GALLERY),
                'video' => $model->hasBlock(Block::TYPE_VIDEO),
                'unit' => true,
                'map' => $model->hasBlock(Block::TYPE_MAP_VIEW),
                'nearby' => $model->hasBlock(Block::TYPE_NEARBY_ACCESS),
                'contact' => $model->hasBlock(Block::TYPE_CONTACT),
            ];
        } else
            $this->bodyClass = 'more-one';

        return $this->render('show', compact('model'));
    }
}
