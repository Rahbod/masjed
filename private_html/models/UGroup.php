<?php

namespace app\models;

use app\components\CustomActiveRecord;
use Yii;

/**
 * This is the model class for table "ugroup".
 *
 * @property integer $id
 * @property string $name
 * @property string $created
 * @property integer $status
 *
 * @property Userugroup[] $userugroups
 * @property User[] $users
 */
class UGroup extends CustomActiveRecord
{
    /**
     * This variables determine that the log is executed or not.
     * Each one is empty or not declared, that event will not be logged.
     */
    protected $insertLogCode = Log::EVENT_USER_ADD_GROUP;
    protected $updateLogCode = Log::EVENT_USER_EDIT_GROUP;
    protected $deleteLogCode = Log::EVENT_USER_REMOVE_GROUP;

    const STATUS_DISABLED = 0;
    const STATUS_ENABLED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ugroup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'status'], 'required'],
            [['created'], 'safe'],
            ['created', 'default', 'value' => date(Yii::$app->params['dbDateTimeFormat']), 'on' => 'insert'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => trans('words', 'base.id'),
            'name' => trans('words', 'base.name'),
            'created' => trans('words', 'base.created'),
            'status' => trans('words', 'base.status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserugroups()
    {
        return $this->hasMany(UserUGroup::className(), ['ugroupID' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'userID'])->viaTable('userugroup', ['ugroupID' => 'id']);
    }

    /**
     * Return valid query
     * @return \yii\db\ActiveQuery
     */
    public static function validQuery()
    {
        return self::find()
            ->where(['status' => self::STATUS_ENABLED])
            ->orderBy(['id' => SORT_DESC]);
    }

    /**
     * @param string $status
     * @return string
     */
    public static function getStatusLabels($status = null)
    {
        $statusLabels = [
            0 => trans('words', 'base.disable'),
            1 => trans('words', 'base.enable'),
        ];
        if (is_null($status))
            return $statusLabels;
        return $statusLabels[$status];
    }

    /**
     * configure attributes options for render in crud form
     * example: [
     *      'attribute name' => [
     *          'type' => self::FORM_FIELD_TYPE_TEXT,
     *          'label' => false,
     *          'options' => [
     *              'placeholder' => $this->getAttributeLabel('name')
     *          ]
     *      ],
     * ]
     *
     * @return array
     */
    public function formAttributes()
    {
        return [];
    }
}