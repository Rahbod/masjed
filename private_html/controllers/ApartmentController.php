<?php

namespace app\controllers;

use app\components\AuthController;
use app\components\CrudControllerTrait;
use app\models\Block;
use app\models\Page;
use app\models\Project;
use app\models\projects\Apartment;
use app\models\projects\ApartmentSearch;
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
 * ApartmentController implements the CRUD actions for Apartment model.
 */
class ApartmentController extends AuthController
{
    use CrudControllerTrait;

    public static $imgDir = 'uploads/apartment';
    public static $pdfDir = 'uploads/apartment/pdf';

    public static $imageOptions = ['thumbnail' => [
        'width' => 100,
        'height' => 100
    ]];

    /**
     * @return string
     */
    public function getModelName()
    {
        return Apartment::className();
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
                'fileName' => Html::getInputName(new Apartment(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'upload' => self::$imgDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Apartment(),
                'attribute' => 'image',
                'options' => static::$imageOptions
            ],
            'upload-banner' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Apartment(), 'banner'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-banner' => [
                'class' => RemoveAction::className(),
                'upload' => self::$imgDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Apartment(),
                'attribute' => 'banner',
                'options' => []
            ],
            'upload-pdf' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Apartment(), 'pdf_file'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('pdf')
                )
            ],
            'delete-pdf' => [
                'class' => RemoveAction::className(),
                'upload' => self::$pdfDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Apartment(),
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

        /** @var Apartment[] $projects */
        $projects = Apartment::find()->orderBy([
            'id' => SORT_DESC,
        ])->all();

        $availableApartments = Apartment::find()->andWhere(['>', Apartment::columnGetString('free_count'), 0])->count();

        return $this->render('list', [
            'projects' => $projects,
            'availableApartments' => $availableApartments,
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
                trans('words', 'Available Apartments'),
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
