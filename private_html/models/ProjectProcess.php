<?php

namespace app\models;

use app\components\customWidgets\CustomActionColumn;
use app\components\Setting;
use Yii;
use yii\helpers\Html;

/**
 * This is the model class for table "item".
 *
 * @property string $description
 * @property string $ar_description
 * @property string $en_description
 * @property int $page_id
 *
 * @property Page $page
 */
class ProjectProcess extends Item
{
    public static $multiLanguage = false;
    public static $modelName = 'project-process';

    public static $morePageSettingKey = 'project_process_more_page_id';

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
            'description' => ['CHAR', ''],
            'ar_description' => ['CHAR', ''],
            'en_description' => ['CHAR', ''],
            'text' => ['CHAR', ''],
            'en_text' => ['CHAR', ''],
            'ar_text' => ['CHAR', ''],
//            'page_id' => ['INTEGER', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function formAttributes()
    {
        return array_merge(parent::formAttributes(), [
            [['description', 'ar_description', 'en_description'], self::FORM_FIELD_TYPE_TEXT_AREA],
            [['text', 'en_text', 'ar_text'], [
                'type' => static::FORM_FIELD_TYPE_TEXT_EDITOR,
                'containerCssClass' => 'col-sm-6',
                'options' => [
                    'options' => ['rows' => 30]
                ]
            ]],
//            'page_id' => [
//                'type' => self::FORM_FIELD_TYPE_SELECT,
//                'items' => Page::getList(),
//                'hint' => 'اختیاری - ' . Html::a('صفحه جدید', ['/page/create', 'return' => request()->url]),
//                'options' => ['prompt' => 'صفحه متنی موردنظر را انتخاب کنید']
//            ],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['description', 'ar_description', 'en_description'], 'string'],
//            ['page_id', 'integer'],
            [['text', 'en_text', 'ar_text'], 'string'],
            ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'description' => trans('words', 'Description'),
            'ar_description' => trans('words', 'Ar Description'),
            'en_description' => trans('words', 'En Description'),
            'text' => trans('words', 'Text'),
            'ar_text' => trans('words', 'Arabic Text'),
            'en_text' => trans('words', 'English Text'),
//            'page_id' => trans('words', 'Page'),
        ]);
    }

    /**
     * {@inheritdoc}
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    public function tableColumns()
    {
        return [
            'name',
            ['class' => CustomActionColumn::className()]
        ];
    }

    /**
     * @param int $limit
     * @param string $orderBy
     * @param int $orderType
     * @return ProjectProcess[]
     */
    public static function getLastRows($limit = 4, $orderBy = 'id', $orderType = SORT_DESC)
    {
        $query = self::find()
            ->orderBy([$orderBy => $orderType])
            ->limit($limit);

//        $query->from('(SELECT * FROM ' . self::tableName() . ' ORDER BY ' . $orderBy . ' DESC LIMIT ' . $limit . ') as t')

        return $query->all();
    }

    public static function getMoreLink()
    {
        $page = Page::findOne(Setting::get(self::$morePageSettingKey));
        return $page ? $page->getUrl() : null;
    }

    public function getDescriptionStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa') {
                return $this->description;
            } else {
                return $this->{Yii::$app->language . '_description'} ?: $this->description;
            }
        }
        return $this->description;
    }

    public function getTextStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa') {
                return $this->text;
            } else {
                return $this->{Yii::$app->language . '_text'} ?: $this->text;
            }
        }
        return $this->text;
    }
}