<?php

namespace app\controllers;

use app\components\AuthController;
use app\components\CrudControllerTrait;
use app\models\Block;
use app\models\Project;
use app\models\projects\OtherConstruction;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use Yii;
use yii\helpers\Html;

/**
 * ConstructionController implements the CRUD actions for Investment model.
 */
class ConstructionController extends AuthController
{
    use CrudControllerTrait;

    public static $imgDir = 'uploads/construction';
    public static $pdfDir = 'uploads/construction/pdf';

    public static $imageOptions = ['thumbnail' => [
        'width' => 100,
        'height' => 100
    ]];

    /**
     * @return string
     */
    public function getModelName()
    {
        return OtherConstruction::className();
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
                'fileName' => Html::getInputName(new OtherConstruction(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'upload' => self::$imgDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new OtherConstruction(),
                'attribute' => 'image',
                'options' => static::$imageOptions
            ],
            'upload-banner' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new OtherConstruction(), 'banner'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-banner' => [
                'class' => RemoveAction::className(),
                'upload' => self::$imgDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new OtherConstruction(),
                'attribute' => 'banner',
                'options' => []
            ],
            'upload-pdf' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new OtherConstruction(), 'pdf_file'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('pdf')
                )
            ],
            'delete-pdf' => [
                'class' => RemoveAction::className(),
                'upload' => self::$pdfDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new OtherConstruction(),
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

        /** @var OtherConstruction[] $projects */
        $projects = OtherConstruction::find()->orderBy([
            'id' => SORT_DESC,
        ])->all();

        $availableOtherConstructions = OtherConstruction::find()->andWhere(['>', OtherConstruction::columnGetString('free_count'), 0])->count();

        return $this->render('list', [
            'projects' => $projects,
            'availableOtherConstructions' => $availableOtherConstructions,
        ]);
    }

    public function actionShow($id)
    {
        $this->setTheme('frontend');
        $this->innerPage = true;

        /** @var OtherConstruction $model */
        $model = $this->findModel($id);

        if ($model->project_type == Project::SINGLE_VIEW) {
            $this->bodyClass = 'final-project-view';
            $this->breadcrumbs = [
                trans('words', 'Other Construction'),
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
