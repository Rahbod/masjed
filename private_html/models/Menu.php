<?php

namespace app\models;

use app\components\MainController;
use app\controllers\MenuController;
use app\controllers\PostController;
use Yii;
use yii\base\ViewContextInterface;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/**
 * This is the model class for table "category".
 *
 * @property boolean $content
 * @property int $menu_type
 * @property int $page_id
 * @property string $action_name
 * @property string $external_link
 * @property string $show_in_footer
 *
 */
class Menu extends Category
{
    public static $multiLanguage = false;

    const MENU_TYPE_PAGE_LINK = 1;
    const MENU_TYPE_ACTION = 2;
    const MENU_TYPE_EXTERNAL_LINK = 3;

    public static $typeName = self::TYPE_MENU;

    public static $menuTypeLabels = [
        self::MENU_TYPE_PAGE_LINK => 'Page Link',
        self::MENU_TYPE_ACTION => 'Action',
        self::MENU_TYPE_EXTERNAL_LINK => 'External Link',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'image' => ['CHAR', ''],
            'content' => ['INTEGER', ''],
            'menu_type' => ['INTEGER', ''],
            'page_id' => ['INTEGER', ''],
            'action_name' => ['CHAR', ''],
            'external_link' => ['CHAR', ''],
            'show_in_footer' => ['INTEGER', ''],
        ]);
    }

    public function formAttributes()
    {
        return array_merge(parent::formAttributes(),[
            'parentID' => [
                'type' => static::FORM_FIELD_TYPE_SELECT,
                'items' => Menu::parentsList(),
                'options' => [
                    'prompt' => 'بدون والد'
                ]
            ],
//            'show_in_footer' => static::FORM_FIELD_TYPE_SWITCH,
            /*'image' => [
                'type' => static::FORM_FIELD_TYPE_DROP_ZONE,
                'containerCssClass' => 'col-sm-12',
                'temp' => MainController::$tempDir,
                'path' => MenuController::$imageDir,
                'filesOptions' => MenuController::$imageOptions,
                'options' => [
                    'url' => Url::to(['upload-image']),
                    'removeUrl' => Url::to(['delete-image']),
                    'sortable' => false, // sortable flag
                    'sortableOptions' => [], // sortable options
                    'htmlOptions' => ['class' => 'single', 'id' => Html::getInputId(new self(), 'image')],
                    'options' => [
                        'createImageThumbnails' => true,
                        'addRemoveLinks' => true,
                        'dictRemoveFile' => 'حذف',
                        'addViewLinks' => true,
                        'dictViewFile' => '',
                        'dictDefaultMessage' => 'جهت آپلود آیکون کلیک کنید',
                        'acceptedFiles' => 'png, jpeg, jpg, svg',
                        'maxFiles' => 1,
                        'maxFileSize' => 0.5,
                    ],
                ]
            ],*/
            'content' => [
                'type' => static::FORM_FIELD_TYPE_SWITCH,
                'options' => ['id' => 'content-trigger']
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            [['menu_type', 'page_id'], 'integer'],
            [['external_link'], 'url'],
            [['action_name', 'external_link', 'image'], 'string'],
            [['show_in_footer'], 'safe'],
            ['show_in_footer', 'default', 'value' => 0],
            ['content', 'default', 'value' => 0]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'image' => trans('words', 'Icon'),
            'menu_type' => trans('words', 'Menu Type'),
            'content' => trans('words', 'Content'),
            'page_id' => trans('words', 'Page Name'),
            'action_name' => trans('words', 'Module Name'),
            'show_in_footer' => trans('words', 'Show in footer'),
            'external_link' => trans('words', 'External Link'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return CategoryQuery|MenuQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }

    public static function parentsList()
    {
        $parents = [];
        $roots = self::find()->roots()->all();
        foreach ($roots as $root) {
            $parents[$root->id] = $root->name;
            $childrens = $root->children(1)->all();
            if ($childrens) {
                foreach ($childrens as $children)
                    $parents[$children->id] = "$root->name/$children->name";
            }
        }
        return $parents;
    }


    public function getMenuTypeLabel($type = false)
    {
        if (!$type)
            $type = $this->menu_type;
        return $type?trans('words', ucfirst(self::$menuTypeLabels[$type])):'-';
    }

    public static function getMenuTypeLabels()
    {
        $lbs = [];
        foreach (self::$menuTypeLabels as $key => $label)
            $lbs[$key] = trans('words', ucfirst($label));
        return $lbs;
    }

    /**
     * @param $context ViewContextInterface|MainController
     * @param $model Menu
     * @param $attribute string
     * @param $form ActiveForm
     *
     * @return string
     * @throws \ReflectionException
     * @throws \yii\base\InvalidConfigException
     */
    public static function renderMenuActionsSelect($context, $model, $attribute, $options = [], $form = false)
    {
        $validControllers = [
            'app\controllers\Controller',
            'app\controllers\PersonController',
            'app\controllers\SiteController',
            'app\controllers\PostController',
        ];
        $controllers = $context->getAllActions([], [], true);
        $controllers = $context->prepareForSelect($controllers);

        $selection = $model->isNewRecord ? null : $model->$attribute;

        Html::addCssClass($options, 'form-control');
        $options['name'] = Html::getInputName($model, $attribute);

        $html = Html::beginTag('div', ['class' => 'form-group m-form__group']);
        if ($form)
            $html .= $form->field($model, $attribute, ['template' => '{label}'])->label();
        $html .= Html::beginTag('select', $options);
        foreach ($controllers as $controller => $actions) {
            $html .= Html::beginTag('optgroup', ['label' => trans('actions', $controller)]);
            $html .= Html::renderSelectOptions($selection, $actions);
            $html .= Html::endTag('optgroup');
        }
        $html .= Html::endTag('select');
        if ($form)
            $html .= $form->field($model, $attribute, ['template' => '{error}'])->error();
        $html .= Html::endTag('div');

        return $html;
    }

    public function getUrl()
    {
        switch ($this->menu_type) {
            case self::MENU_TYPE_PAGE_LINK:
                $page = Page::findOne($this->page_id);
                if (!$page)
                    return '#';
                return $page->getUrl();
            case self::MENU_TYPE_ACTION:
                $url = str_replace('@', '/', $this->action_name);
                return Url::to(["/$url"]);
            case self::MENU_TYPE_EXTERNAL_LINK:
                return $this->external_link;
            default:
                return '#';
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        app()->cache->delete('menus');
    }

    public function afterDelete()
    {
        parent::afterDelete();
        app()->cache->delete('menus');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parentID']);
    }
}