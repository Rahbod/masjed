<?php

namespace app\models;

use app\components\MainController;
use app\controllers\ProjectController;
use app\models\blocks\Contact;
use app\models\blocks\OtherUnits;
use app\models\blocks\RelatedProjects;
use app\models\blocks\UnitDetails;
use app\models\blocks\Units;
use app\models\Unit;
use app\models\projects\ProjectInterface;
use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

/**
 * This is the model class for table "item".
 *
 * @property mixed|null project_type
 * @property string subtitle
 * @property string en_subtitle
 * @property string ar_subtitle
 * @property string location
 * @property string en_location
 * @property string ar_location
 * @property string area_size
 * @property string pdf_file
 * @property string banner
 *
 * @property Block[] blocks
 * @property Unit[] units
 * @property string location_two
 * @property string en_location_two
 * @property string ar_location_two
 * @property int special
 */
class Project extends Item
{
    const TYPE_AVAILABLE_APARTMENT = 1;
    const TYPE_INVESTMENT = 2;
    const TYPE_OTHER_CONSTRUCTION = 3;

    const SINGLE_VIEW = 1;
    const MULTI_VIEW = 2;

    public static $multiLanguage = false;
    public static $modelName = 'project';

    public static $typeLabels = [
        self::TYPE_AVAILABLE_APARTMENT => 'Available apartments',
        self::TYPE_INVESTMENT => 'Investments',
        self::TYPE_OTHER_CONSTRUCTION => 'Other constructions'
    ];

    public static $typeModels = [
        self::TYPE_AVAILABLE_APARTMENT => 'app\models\projects\Apartment',
        self::TYPE_INVESTMENT => 'app\models\projects\Investment',
        self::TYPE_OTHER_CONSTRUCTION => 'app\models\projects\OtherConstruction'
    ];

    public static $projectTypeLabels = [
        self::SINGLE_VIEW => 'Single view',
        self::MULTI_VIEW => 'Multi view',
    ];

    /** @var Unit */
    public $unit = null; // unit that belongs to this project, comes this in Unit Model in render function

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            // define common fields in project types
            'special' => ['INTEGER', ''],
            'description' => ['CHAR', ''],
            'ar_description' => ['CHAR', ''],
            'en_description' => ['CHAR', ''],
            'begin_date' => ['CHAR', ''],
            'construction_time' => ['CHAR', ''],
            'location' => ['CHAR', ''],
            'ar_location' => ['CHAR', ''],
            'en_location' => ['CHAR', ''],
            'subtitle' => ['CHAR', ''],
            'ar_subtitle' => ['CHAR', ''],
            'en_subtitle' => ['CHAR', ''],
            'location_two' => ['CHAR', ''],
            'ar_location_two' => ['CHAR', ''],
            'en_location_two' => ['CHAR', ''],
            'image' => ['CHAR', ''],
            'area_size' => ['INTEGER', ''],
            'unit_count' => ['INTEGER', ''],
            'unit_per_floor_count' => ['INTEGER', ''],
            'free_count' => ['INTEGER', ''],
            'sold_count' => ['INTEGER', ''],
            'project_type' => ['INTEGER', ''],
            'pdf_file' => ['CHAR', ''],
            'banner' => ['CHAR', ''],
            'bg_color' => ['CHAR', ''],

            'floor_number' => ['INTEGER', ''],
            'unit_number' => ['INTEGER', ''],
            'elevator' => ['INTEGER', ''],
            'age_of_the_building' => ['INTEGER', ''],
            'parking' => ['INTEGER', ''],
            'usage' => ['INTEGER', ''],
            'view' => ['CHAR', 'INTEGER'],
            'direction' => ['INTEGER', ''],
            'unit_per_floor_number' => ['INTEGER', ''],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['modelID', 'default', 'value' => isset(Yii::$app->controller->models[self::$modelName]) ? Yii::$app->controller->models[self::$modelName] : null],
            [['project_type'], 'required', 'except' => 'clone'],
            [['special'], 'integer'],
            [['special'], 'default', 'value' => 0],
            [['description', 'ar_description', 'en_description'], 'string'],
            [['banner', 'pdf_file', 'subtitle', 'ar_subtitle', 'en_subtitle', 'location_two', 'bg_color', 'ar_location_two', 'en_location_two', 'begin_date', 'construction_time', 'location', 'en_location', 'ar_location', 'image'], 'string'],
            [['area_size', 'unit_count', 'free_count', 'sold_count', 'project_type'], 'integer'],
            [['unit_per_floor_number', 'direction', 'view', 'floor_number', 'unit_number', 'parking', 'elevator', 'age_of_the_building', 'usage'], 'integer']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'special' => trans('words', 'Special Project'),
            'project_type' => trans('words', 'Project type'),
            'description' => trans('words', 'Building Description'),
            'ar_description' => trans('words', 'Ar Building Description'),
            'en_description' => trans('words', 'En Building Description'),
            'subtitle' => trans('words', 'Subtitle'),
            'en_subtitle' => trans('words', 'En Subtitle'),
            'ar_subtitle' => trans('words', 'Ar Subtitle'),
            'location_two' => trans('words', 'Location two'),
            'en_location_two' => trans('words', 'En Location two'),
            'ar_location_two' => trans('words', 'Ar Location two'),
            'image' => trans('words', 'Image'),
            'begin_date' => trans('words', 'Begin date'),
            'construction_time' => trans('words', 'Construction time'),
            'location' => trans('words', 'Location'),
            'en_location' => trans('words', 'En Location'),
            'ar_location' => trans('words', 'Ar Location'),
            'area_size' => trans('words', 'Area size'),
            'unit_count' => trans('words', 'Unit count'),
            'free_count' => trans('words', 'Free count'),
            'sold_count' => trans('words', 'Sold count'),
            'pdf_file' => trans('words', 'Pdf file'),
            'banner' => trans('words', 'Banner'),
            'bg_color' => trans('words', 'Background color'),
            'floor_number' => trans('words', 'Floor count'),
            'unit_number' => trans('words', 'Units count'),
            'elevator' => trans('words', 'Elevator'),
            'age_of_the_building' => trans('words', 'Age of the building'),
            'parking' => trans('words', 'Parking'),
            'usage' => trans('words', 'Usage'),
            'view' => trans('words', 'View'),
            'direction' => trans('words', 'Construction direction'),
            'unit_per_floor_number' => trans('words', 'Unit per floor number'),
        ]);
    }

    public function getTypeLabel($type = false)
    {
        if (!$type)
            $type = $this->type;
        return trans('words', ucfirst(self::$typeLabels[$type]));
    }

    public static function getTypeLabels()
    {
        $lbs = [];
        foreach (self::$typeLabels as $key => $label)
            $lbs[$key] = trans('words', ucfirst($label));
        return $lbs;
    }

    public function getProjectTypeLabel($type = false)
    {
        if (!$type)
            $type = $this->project_type;
        return trans('words', ucfirst(self::$projectTypeLabels[$type]));
    }

    public static function getProjectTypeLabels()
    {
        $lbs = [];
        foreach (self::$projectTypeLabels as $key => $label)
            $lbs[$key] = trans('words', ucfirst($label));
        return $lbs;
    }

    /**
     * {@inheritdoc}
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }

    public function formAttributes()
    {
        return array_merge(parent::formAttributes(), [
            'hr' => self::FORM_SEPARATOR,
            [['description', 'ar_description', 'en_description'],
                [
                    'type' => self::FORM_FIELD_TYPE_TEXT_AREA,
                    'options' => ['dir' => 'auto', 'rows' => 5]
                ]],
            [['subtitle', 'ar_subtitle', 'en_subtitle'], self::FORM_FIELD_TYPE_TEXT],
            'project_type' => [
                'type' => self::FORM_FIELD_TYPE_SELECT,
                'items' => self::getProjectTypeLabels(),
                'options' => ['id' => 'project_type']
            ],
            'special' => self::FORM_FIELD_TYPE_SWITCH,
            'construction_time' => ['type' => self::FORM_FIELD_TYPE_TEXT, 'hint' => 'بر حسب ماه'],
            'begin_date' => [
                'type' => self::FORM_FIELD_TYPE_TEXT,
                'hint' => '2019/10/01',
                'options' => ['placeholder' => '2019/10/01']
//                'type' => self::FORM_FIELD_TYPE_DATE,
//                'options' => [
//                    'options' => array(
//                        'format' => 'yyyy/mm/dd',
//                        'viewformat' => 'yyyy/mm/dd',
//                        'placement' => 'right',
//                    ),
//                    'htmlOptions' => [
//                        'class' => 'form-control m-input m-input--solid',
//                        'autocomplete' => 'off'
//                    ]
//                ]
            ],
            [['location', 'ar_location', 'en_location', 'location_two', 'ar_location_two', 'en_location_two'], self::FORM_FIELD_TYPE_TEXT],
            'area_size' => ['type' => self::FORM_FIELD_TYPE_TEXT, 'hint' => 'متر'],
            'unit_count' => self::FORM_FIELD_TYPE_TEXT,
            'free_count' => self::FORM_FIELD_TYPE_TEXT,
            'sold_count' => self::FORM_FIELD_TYPE_TEXT,
            'bg_color' => self::FORM_FIELD_TYPE_TEXT,
            'sep' => [
                'type' => self::FORM_SEPARATOR,
                'containerCssClass' => 'col-sm-12'
            ],
            [
                ['floor_number', 'parking', 'elevator', 'age_of_the_building', 'unit_per_floor_number'],
                ['type' => self::FORM_FIELD_TYPE_TEXT, 'containerCssClass' => 'col-sm-3']
            ],
            'usage' => ['type' => self::FORM_FIELD_TYPE_SELECT, 'listSlug' => 'usage', 'containerCssClass' => 'col-sm-3'],
            'view' => ['type' => self::FORM_FIELD_TYPE_SELECT, 'listSlug' => 'view', 'containerCssClass' => 'col-sm-3'],
            'direction' => ['type' => self::FORM_FIELD_TYPE_SELECT, 'listSlug' => 'direction', 'containerCssClass' => 'col-sm-3'],
            'sep2' => [
                'type' => self::FORM_SEPARATOR,
                'containerCssClass' => 'col-sm-12'
            ],
            'image' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'hint' => 'حداقل سایز تصویر: 600 در 600 پیکسل',
                'containerCssClass' => 'col-sm-6',
                'temp' => MainController::$tempDir,
                'path' => ProjectController::$imgDir,
                'filesOptions' => ProjectController::$imageOptions,
                'options' => [
                    'url' => Url::to(['upload-image']),
                    'removeUrl' => Url::to(['delete-image']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'image')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg',
                        'maxFiles' => 1,
                        'maxFileSize' => 0.5,
                    ],
                ]
            ],
            'pdf_file' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-6',
                'temp' => MainController::$tempDir,
                'path' => ProjectController::$pdfDir,
                'filesOptions' => [],
                'options' => [
                    'url' => Url::to(['upload-pdf']),
                    'removeUrl' => Url::to(['delete-pdf']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'pdf_file')],
                    'options' => [
                        'createImageThumbnails' => false,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود فایل Pdf کلیک کنید',
                        'acceptedFiles' => 'pdf',
                        'maxFiles' => 1,
                        'maxFileSize' => 50,
                    ],
                ]
            ],
            'banner' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'hint' => 'تصویر کاور برای پروژه های چند معرفی، حداقل سایز تصویر: 1920 در 1080 پیکسل',
                'containerCssClass' => 'col-sm-12 banner-container d-none',
                'temp' => MainController::$tempDir,
                'path' => ProjectController::$imgDir,
                'filesOptions' => [],
                'options' => [
                    'url' => Url::to(['upload-banner']),
                    'removeUrl' => Url::to(['delete-banner']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => '', 'id' => Html::getInputId(new self(), 'banner')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود تصویر کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg',
                        'maxFiles' => 1,
                        'maxFileSize' => 5,
                    ],
                ]
            ],

            'js_script' => [
                'type' => static::FORM_JS_SCRIPT,
                'js' => <<<JS
if($('#project_type').val() === '2')
    $(".banner-container").removeClass('d-none');
$("body").on("change", '#project_type', function(e) {
    if($(this).val() === '2')
        $(".banner-container").removeClass('d-none');
    else
        $(".banner-container").addClass('d-none');
});
JS
            ],
        ]);
    }

    public function getBlocks()
    {
        return $this->hasMany(Block::className(), [Block::columnGetString('itemID') => 'id'])->orderBy([Block::columnGetString('sort') => SORT_ASC]);
    }

    public function hasBlock($type)
    {
        return Block::find()->andWhere(['type' => $type, Block::columnGetString('itemID') => $this->id])->orderBy([Block::columnGetString('sort') => SORT_ASC])->one();
    }

    public function getUnits()
    {
        return $this->hasMany(Unit::className(), [Unit::columnGetString('itemID') => 'id']);
    }

    public function getUnitCount($free = false)
    {
        return $free ? $this->free_count : $this->sold_count;
        $q = $this->hasMany(Unit::className(), [Unit::columnGetString('itemID') => 'id']);
        if ($free)
            $q->andWhere([Unit::columnGetString('sold') => 0]);
        return $q->count();
    }

    /**
     * @inheritDoc
     */
    public function render(View $view)
    {
        if ($this->project_type == self::SINGLE_VIEW)
            return $this->renderBlocks($view, $this);
        else {
            $className = strtolower($this->formName());
            if ($className == 'otherconstruction')
                $className = 'construction';
            return $view->renderAjax('/' . $className . '/multi_view', ['project' => $this]);
        }
    }

    /**
     * @param View $view
     * @param Project $project
     * @param bool|Unit $unit
     * @return string
     */
    public function renderBlocks($view, $project, $unit = false)
    {
        if ($unit)
            $project->unit = $unit;

        $output = '';
        foreach ($this->getBlocks()->andWhere(['!=', 'type', Block::TYPE_CONTACT])->all() as $block) {
            $type = $block->type;
            /** @var Block $modelClass */
            $modelClass = Block::$typeModels[$type];
            $block = $modelClass::findOne($block->id);
            $output .= $block->render($view, $project);
        }

        /** @var Contact $contactBlock */
        $contactBlock = Contact::find()->andWhere([Block::columnGetString('itemID') => $this->id])->orderBy([Block::columnGetString('sort') => SORT_ASC])->one();

        // render static unit blocks
        if ($project->unit) {
            // render unit details
            $block = new UnitDetails($project->unit);
            $output .= $block->render($view);

            // render contact block
            if($contactBlock)
                $output .= $contactBlock->render($view, $project);

            // render other units
            $block = new OtherUnits($project->unit);
            $output .= $block->render($view);
        } else {
            // render project units
            $block = new Units();
            $output .= $block->render($view, $this);

            // render contact block
            if($contactBlock)
                $output .= $contactBlock->render($view, $project);

            // render related projects
            $block = new RelatedProjects();
            $output .= $block->render($view, $this);
        }

        return $output;
    }

    public function getDescriptionSrc()
    {
        if (!static::$multiLanguage && Yii::$app->language != 'fa')
            return $this->{Yii::$app->language . '_description'} ?: $this->description;
        return $this->description;
    }

    public function getSubtitleStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa')
                return $this->subtitle;
            else
                return $this->{Yii::$app->language . '_subtitle'} ?: $this->subtitle;
        }
        return $this->subtitle;
    }

    public function getLocationStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa')
                return $this->location;
            else
                return $this->{Yii::$app->language . '_location'} ?: $this->location;
        }
        return $this->location;
    }

    public function getPdfUrl($dir)
    {
        $path = alias('@webroot') . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . $this->pdf_file;
        if ($this->pdf_file and is_file($path))
            return alias('@web/') . $dir . '/' . $this->pdf_file;
        return false;
    }

    public function getLocationTwoStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa')
                return $this->location_two;
            else
                return $this->{Yii::$app->language . '_location_two'} ?: $this->location_two;
        }
        return $this->location_two;
    }

    public function hasField($name)
    {
        if (empty($name))
            return false;
        $fields = array_keys($this->dynaDefaults);
        return in_array($name, $fields) && $this->$name !== null;
    }

    public function beforeSave($insert)
    {
        if ($this->special) {
            /** @var Project $modelClass */
            $modelClass = get_called_class();
            /** @var Project $lastSpec */
            $lastSpec = $modelClass::find()->andWhere([self::columnGetString('special') => 1])->one();
            if ($lastSpec) {
                $lastSpec->special = 0;
                $lastSpec->save();
            }
        }

        return parent::beforeSave($insert);
    }

    public function getModelImage()
    {
        if (isset($this->image) && is_file(Yii::getAlias('@webroot/uploads/project/') . $this->image))
            return Yii::getAlias('@web/uploads/project/') . $this->image;
        return Yii::getAlias('@webapp/public_html/themes/frontend/images/default.jpg');
    }

    public function getUrl()
    {
        return Url::to(['/project/show', 'id' => $this->id]);
    }
}