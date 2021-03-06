<?php

namespace app\models;

use app\models\blocks\BlockInterface;
use richardfan\sortable\SortableAction;
use Yii;
use yii\web\View;

/**
 * This is the model class for table "item".
 *
 * @property int $itemID
 * @property int $sort
 *
 * @property Project $project
 * @property Unit $unit
 */
class Block extends Item implements BlockInterface
{
    const TYPE_BANNER = 1;
    const TYPE_IMAGE = 2;
    const TYPE_VIDEO = 3;
    const TYPE_MAP_VIEW = 4;
    const TYPE_NEARBY_ACCESS = 5;
    const TYPE_GALLERY = 6;
    const TYPE_CONTACT = 7;
//    const TYPE_UNITS_BLOCK = 6;
//    const TYPE_RELATED_PROJECTS = 7;

    public static $multiLanguage = false;
    public static $modelName = 'block';

    public static $typeLabels = [
        self::TYPE_BANNER => 'Banner',
        self::TYPE_IMAGE => 'Image',
        self::TYPE_VIDEO => 'Video',
        self::TYPE_MAP_VIEW => 'Map view',
        self::TYPE_NEARBY_ACCESS => 'Nearby access',
        self::TYPE_GALLERY => 'Gallery',
        self::TYPE_CONTACT => 'Contact',
//        self::TYPE_UNITS_BLOCK => 'Units block',
//        self::TYPE_RELATED_PROJECTS => 'Related projects block',
    ];

    public static $typeModels = [
        self::TYPE_BANNER => 'app\models\blocks\Banner',
        self::TYPE_IMAGE => 'app\models\blocks\Image',
        self::TYPE_VIDEO => 'app\models\blocks\Video',
        self::TYPE_MAP_VIEW => 'app\models\blocks\Map',
        self::TYPE_NEARBY_ACCESS => 'app\models\blocks\NearbyAccess',
        self::TYPE_GALLERY => 'app\models\blocks\Gallery',
        self::TYPE_CONTACT => 'app\models\blocks\Contact',
//        self::TYPE_UNITS_BLOCK => 'app\models\blocks\Units',
//        self::TYPE_RELATED_PROJECTS => 'app\models\blocks\RelatedProjects',
    ];


    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'itemID' => ['INTEGER', ''],
            'sort' => ['INTEGER', ''],

            //
            'image' => ['CHAR', ''],
            'video' => ['CHAR', ''],
        ]);
    }


    public function formAttributes()
    {
        return [
            'name' => static::FORM_FIELD_TYPE_TEXT,
            'status' => [
                'type' => static::FORM_FIELD_TYPE_SELECT,
                'items' => self::getStatusFilter()
            ],
            'sep' => [
                'type' => self::FORM_SEPARATOR,
                'containerCssClass' => 'col-sm-12'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['modelID', 'default', 'value' => isset(Yii::$app->controller->models[self::$modelName]) ? Yii::$app->controller->models[self::$modelName] : null],
            [['itemID', 'type'], 'required'],
            [['itemID', 'sort'], 'integer'],
            [['sort'], 'safe', 'on' => SortableAction::SORTING_SCENARIO],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'itemID' => trans('words', 'Project ID'),
            'sort' => trans('words', 'Sort'),
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

    /**
     * {@inheritdoc}
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if ($insert)
            $this->sort = $this->getMaxSort() + 1;
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * Return maximum saved sort
     * @return integer
     */
    public function getMaxSort()
    {
        return self::find()->where([
            'itemID' => $this->itemID
        ])->max(self::columnGetString('sort'));
    }

    public function getProject()
    {
        $model = Project::findOne($this->itemID);
        if (!$model)
            return null;
        $type = $model->type;
        /** @var Block $modelClass */
        $modelClass = Project::$typeModels[$type];
        return $modelClass::findOne($model->id);
    }

    public function getUnit()
    {
        return Unit::findOne($this->itemID);
//        return $this->hasOne(Unit::className(), [self::columnGetString('itemID') => 'id']);
    }

    /**
     * @param View $view
     * @param $project
     * @return mixed
     */
    public function render(View $view, $project)
    {
        return '';
    }
}