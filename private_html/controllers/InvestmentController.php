<?php

namespace app\controllers;

use app\components\AuthController;
use app\components\CrudControllerTrait;
use app\models\Block;
use app\models\Project;
use app\models\projects\Investment;
use devgroup\dropzone\RemoveAction;
use devgroup\dropzone\UploadAction;
use yii\helpers\Html;

/**
 * InvestmentController implements the CRUD actions for Investment model.
 */
class InvestmentController extends AuthController
{
    use CrudControllerTrait;

    public static $imgDir = 'uploads/investment';
    public static $pdfDir = 'uploads/investment/pdf';

    public static $imageOptions = ['thumbnail' => [
        'width' => 100,
        'height' => 100
    ]];

    /**
     * @return string
     */
    public function getModelName()
    {
        return Investment::className();
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
                'fileName' => Html::getInputName(new Investment(), 'image'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-image' => [
                'class' => RemoveAction::className(),
                'upload' => self::$imgDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Investment(),
                'attribute' => 'image',
                'options' => static::$imageOptions
            ],
            'upload-banner' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Investment(), 'banner'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ],
            'delete-banner' => [
                'class' => RemoveAction::className(),
                'upload' => self::$imgDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Investment(),
                'attribute' => 'banner',
                'options' => []
            ],
            'upload-pdf' => [
                'class' => UploadAction::className(),
                'fileName' => Html::getInputName(new Investment(), 'pdf_file'),
                'rename' => UploadAction::RENAME_UNIQUE,
                'validateOptions' => array(
                    'acceptedTypes' => array('pdf')
                )
            ],
            'delete-pdf' => [
                'class' => RemoveAction::className(),
                'upload' => self::$pdfDir,
                'storedMode' => RemoveAction::STORED_DYNA_FIELD_MODE,
                'model' => new Investment(),
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

        /** @var Investment[] $projects */
        $projects = Investment::find()->orderBy([
            'id' => SORT_DESC,
        ])->all();

        $availableInvestments = Investment::find()->andWhere(['>', Investment::columnGetString('free_count'), 0])->count();

        return $this->render('list', [
            'projects' => $projects,
            'availableInvestments' => $availableInvestments,
        ]);
    }

    public function actionShow($id)
    {
        $this->setTheme('frontend');
        $this->innerPage = true;

        /** @var Investment $model */
        $model = $this->findModel($id);

        if ($model->project_type == Project::SINGLE_VIEW) {
            $this->bodyClass = 'final-project-view';
            $this->breadcrumbs = [
                trans('words', 'Available Investments'),
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
