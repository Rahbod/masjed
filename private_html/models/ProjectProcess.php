<?php

namespace app\models;

use app\components\customWidgets\CustomActionColumn;
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

                'page_id' => ['INTEGER', '']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function formAttributes()
    {
        return array_merge(parent::formAttributes(), [
                [['description', 'ar_description', 'en_description'], self::FORM_FIELD_TYPE_TEXT_AREA],
                'page_id' => [
                        'type' => self::FORM_FIELD_TYPE_SELECT,
                        'items' => Page::getList(),
                        'hint' => ' - اختیاری' . Html::a('صفحه جدید', ['/page/create', 'return' => request()->url]),
                        'options' => ['prompt' => 'صفحه متنی موردنظر را انتخاب کنید']
                ],
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
                [['description', 'ar_description', 'en_description'], 'string'],
                ['page_id', 'integer'],
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
                'page_id' => trans('words', 'Page'),
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
     * @return ProjectProcess[]
     */
    public static function getLastRows($limit = 4, $orderBy = 'id')
    {
        $query = self::find();

        $query->from('(SELECT * FROM ' . self::tableName() . ' ORDER BY ' . $orderBy . ' DESC LIMIT ' . $limit . ') as t')
                ->orderBy([$orderBy => SORT_ASC]);

        return $query->all();
    }

    public static function getMoreLink()
    {
        return '';
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
}