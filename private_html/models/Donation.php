<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "donation".
 *
 * @property int $id
 * @property string $name
 * @property string $mobile
 * @property double $amount
 * @property resource $dyna
 * @property string $status
 * @property string $create_date
 */
class Donation extends \app\components\MultiLangActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'donation';
    }

    public function init()
    {
        parent::init();
        $this->dynaDefaults = array_merge($this->dynaDefaults, [

        ]);
    }

    /**
    * {@inheritdoc}
    */
    public function formAttributes()
    {
        return [];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['name', 'amount'], 'required'],
            [['amount', 'status'], 'number'],
            [['dyna'], 'string'],
            [['name', 'mobile'], 'string', 'max' => 255],
            [['create_date'], 'string', 'max' => 20],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'id' => Yii::t('words', 'ID'),
            'name' => Yii::t('words', 'Name'),
            'mobile' => Yii::t('words', 'Mobile'),
            'amount' => Yii::t('words', 'Amount'),
            'dyna' => Yii::t('words', 'Dyna'),
            'status' => Yii::t('words', 'Status'),
            'create_date' => Yii::t('words', 'Create Date'),
        ]);
    }
}