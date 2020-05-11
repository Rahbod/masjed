<?php

namespace app\models;

use Yii;
use app\components\DynamicActiveRecord;

/**
 * This is the model class for table "message".
 *
 * @property int $id
 * @property string $name
 * @property string $type Enum: cnt: contact us, sgn: suggestions, cmp: complaints
 * @property string $tel
 * @property string $body
 * @property string $subject
 * @property string $status
 * @property string $email
 * @property string $department_id
 * @property resource $dyna All fields
 * @property string $created
 * @property int $degree
 */
class Message extends DynamicActiveRecord
{
    const STATUS_UNREAD = 0;
    const STATUS_PENDING = 1;
    const STATUS_REVIEWED = 2;
    const STATUS_CALLED = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'message';
    }

    public function init()
    {
        parent::init();

        $this->type = 'cnt';

        preg_match('/(app\\\\models\\\\)(\w*)(Search)/', $this::className(), $matches);
        if (!$matches)
            $this->status = self::STATUS_UNREAD;

        $this->dynaDefaults = array_merge($this->dynaDefaults, [
            'subject' => ['CHAR', ''],
            'status' => ['INTEGER', ''],
            'email' => ['CHAR', ''],
            'department_id' => ['CHAR', ''],
            'degree' => ['CHAR', ''],
            'country' => ['CHAR', ''],
            'city' => ['CHAR', ''],
            'address' => ['CHAR', ''],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name','email', 'body'], 'required'],
            [['dyna', 'email', 'subject', 'country', 'city', 'address'], 'string'],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_UNREAD],
            ['email', 'email'],
            [['name'], 'string', 'max' => 511],
            [['tel'], 'string', 'max' => 15],
            [['body'], 'string'],
            [['created'], 'string', 'max' => 20],
            [['department_id'], 'safe'],
            [['degree'], 'string'],
            [['created'], 'default', 'value' => time()],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => trans('words', 'ID'),
            'status' => trans('words', 'Status'),
            'created' => trans('words', 'Created'),
            'name' => trans('words', 'Name and Family'),
            'email' => trans('words', 'Email'),
            'subject' => trans('words', 'Subject'),
            'body' => trans('words', 'Body'),
            'department_id' => trans('words', 'Department ID'),
            'tel' => trans('words', 'Tel'),
            'degree' => trans('words', 'Degree'),
            'country' => trans('words', 'Country'),
            'city' => trans('words', 'City'),
            'address' => trans('words', 'Address'),
        ]);
    }


    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    public static function getDegrees($id = null)
    {
        $degrees = [
            1 => trans('words', 'Diploma'),
            2 => trans('words', 'Associate Degree'),
            3 => trans('words', 'Bachelor'),
            4 => trans('words', 'Senior'),
            5 => trans('words', 'PhD Degree'),
            6 => trans('words', 'Professor'),
        ];
        if (is_null($id))
            return $degrees;
        return $degrees[$id];
    }

    public static function getSubjects($id = null)
    {
        $subjects = [
            1 => trans('words', 'Suggestions'),
            2 => trans('words', 'Critics'),
        ];
        if (is_null($id))
            return $subjects;
        return $subjects[$id];
    }

    public static function getStatusLabels($status = null, $html = false)
    {
        $statusLabels = [
            self::STATUS_UNREAD => 'خوانده نشده',
            self::STATUS_PENDING => 'در حال بررسی',
            self::STATUS_REVIEWED => 'بررسی شده',
            self::STATUS_CALLED => 'اطلاع رسانی شده',
        ];
        if (is_null($status))
            return $statusLabels;

        if ($html) {
            switch ($status) {
                case self::STATUS_UNREAD:
                    $class = 'danger';
                    break;
                case self::STATUS_PENDING:
                    $class = 'warning';
                    break;
                case self::STATUS_REVIEWED:
                    $class = 'primary';
                    break;
                case self::STATUS_CALLED:
                    $class = 'success';
                    break;
            }
            return "<span class='text-{$class}'>$statusLabels[$status]</span>";
        }
        return $statusLabels[$status];
    }

    public static function getStatusFilter()
    {
        return self::getStatusLabels();
    }
}
