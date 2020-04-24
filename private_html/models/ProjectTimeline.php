<?php

namespace app\models;

use app\components\customWidgets\CustomActionColumn;
use Arcanedev\Arabic\DateTime;
use Yii;

/**
 * This is the model class for table "item".
 *
 * @property int $date
 * @property int $state
 * @property string $required_amount
 * @property string $submitted_amount
 * @property string $section_number
 * @property string $ar_section_number
 * @property string $en_section_number
 * @property string $description
 * @property string $ar_description
 * @property string $en_description
 */
class ProjectTimeline extends Item
{
    const STATE_TODO = 1;
    const STATE_DOING = 2;
    const STATE_DONE = 3;

    public static $multiLanguage = false;
    public static $modelName = 'project-timeline';

    public $stateClasses = [
            self::STATE_TODO => 'todo',
            self::STATE_DOING => 'doing',
            self::STATE_DONE => 'done',
    ];

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [
                'date' => ['CHAR', ''],
                'state' => ['INTEGER', ''],
                'required_amount' => ['CHAR', ''],
                'submitted_amount' => ['CHAR', ''],

                'section_number' => ['CHAR', ''],
                'ar_section_number' => ['CHAR', ''],
                'en_section_number' => ['CHAR', ''],

                'description' => ['CHAR', ''],
                'ar_description' => ['CHAR', ''],
                'en_description' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function formAttributes()
    {
        return array_merge(parent::formAttributes(), [
                [['section_number', 'ar_section_number', 'en_section_number'], self::FORM_FIELD_TYPE_TEXT],
                [
                        ['description', 'ar_description', 'en_description'],
                        [
                                'type' => self::FORM_FIELD_TYPE_TEXT_AREA,
                                'options' => ['rows' => 4]
                        ]
                ],
                'state' => [
                        'type' => self::FORM_FIELD_TYPE_SELECT,
                        'items' => self::getStateLabels(),
                        'options' => ['prompt' => 'انتخاب کنید']
                ],
                [
                        ['required_amount', 'submitted_amount'],
                        [
                                'type' => self::FORM_FIELD_TYPE_TEXT,
                                'hint' => 'مبلغ به دلار',
                                'options' => ['class' => 'form-control m-input m-input--solid digitFormat']
                        ]
                ],
                'date' => self::FORM_FIELD_TYPE_DATE,
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
                ['state', 'integer'],
                [
                        [
                                'date',
                                'required_amount',
                                'submitted_amount',
                                'section_number',
                                'ar_section_number',
                                'en_section_number',
                                'description',
                                'ar_description',
                                'en_description'
                        ],
                        'string'
                ],
                ['modelID', 'default', 'value' => Model::findOne(['name' => self::$modelName])->id],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
                'date' => trans('words', 'Date'),
                'state' => trans('words', 'State'),
                'required_amount' => trans('words', 'Required Amount'),
                'submitted_amount' => trans('words', 'Submitted Amount'),
                'section_number' => trans('words', 'Section number'),
                'ar_section_number' => trans('words', 'Ar Section number'),
                'en_section_number' => trans('words', 'En Section number'),
                'description' => trans('words', 'Description'),
                'ar_description' => trans('words', 'Ar Description'),
                'en_description' => trans('words', 'En Description'),
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
     * @return ProjectTimeline[]
     */
    public static function getLastRows()
    {
        $query = self::find();
        $query->orderBy([self::columnGetString('date') => SORT_DESC]);

        return $query->all();
    }

    public static function getStateLabels($state = null, $html = false)
    {
        $stateLabels = [
                self::STATE_TODO => trans('words', 'Todo'),
                self::STATE_DOING => trans('words', 'Doing'),
                self::STATE_DONE => trans('words', 'Done'),
        ];
        if (is_null($state)) {
            return $stateLabels;
        }

        if ($html) {
            switch ($state) {
                case self::STATE_DONE:
                    $class = 'success';
                    $icon = '<i class="fa fa-check-circle"></i>';
                    break;
                case self::STATE_DOING:
                    $class = 'warning';
                    $icon = '<i class="fa fa-clock"></i>';
                    break;
                case self::STATE_TODO:
                    $class = 'danger';
                    $icon = '<i class="fa fa-times-circle"></i>';
                    break;
            }
            return "<span class='text-{$class}'>$icon</span>";
        }
        return $stateLabels[$state];
    }

    public function tableColumns()
    {
        return [
                'name',
                'section_number',
                [
                        'attribute' => 'date',
                        'value' => function (ProjectTimeline $model) {
                            return \jDateTime::date('Y/m/d', $model->date);
                        },
                        'format' => 'raw'
                ],
                [
                        'attribute' => 'state',
                        'value' => function (ProjectTimeline $model) {
                            return ProjectTimeline::getStateLabels($model->state, true);
                        },
                        'format' => 'raw'
                ],
                ['class' => CustomActionColumn::className()]
        ];
    }

    public function beforeSave($insert)
    {
        if ($this->date) {
            $this->date = substr($this->date, 0, 10);
        }

        $this->required_amount = $this->required_amount ? str_replace(',', '', $this->required_amount) : null;
        $this->submitted_amount = $this->submitted_amount ? str_replace(',', '', $this->submitted_amount) : null;

        return parent::beforeSave($insert);
    }

    public function getDateYear()
    {
        switch (app()->language) {
            case 'fa':
                return \jDateTime::date('Y', $this->date);
            case 'en':
                return date('Y', $this->date);
            case 'ar':
                $d = new DateTime();
                $d->setTimestamp($this->date);
                return $d->hijriDate($this->date, false,':year');
        }
        return null;
    }

    public function getDateDayAndMonth()
    {
        switch (app()->language) {
            case 'fa':
                return \jDateTime::date('d m', $this->date);
            case 'en':
                return date('d m', $this->date);
            case 'ar':
                $d = new DateTime();
                $d->setTimestamp($this->date);
                return $d->hijriDate($this->date, false,':day :monthName');
        }
        return null;
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

    public function getSectionNumberStr()
    {
        if (!static::$multiLanguage) {
            if (Yii::$app->language == 'fa') {
                return $this->section_number;
            } else {
                return $this->{Yii::$app->language . '_section_number'} ?: $this->section_number;
            }
        }
        return $this->section_number;
    }
}