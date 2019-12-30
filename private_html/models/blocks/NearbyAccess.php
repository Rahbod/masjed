<?php

namespace app\models\blocks;

use app\models\Block;
use app\models\Project;
use Yii;
use yii\web\View;

/**
 * This is the model class for table "item".
 *
 * @property int $shrine_distance
 * @property int $shopping_distance
 * @property int $hospital_distance
 * @property int $metro_distance
 * @property int $laundry_distance
 * @property int $airport_distance
 * @property int $gas_distance
 * @property int $restaurant_distance
 * @property string $shrine_link
 * @property string $shopping_link
 * @property string $hospital_link
 * @property string $metro_link
 * @property string $laundry_link
 * @property string $airport_link
 * @property string $gas_link
 * @property string $restaurant_link
 */
class NearbyAccess extends Block
{
    public static $typeName = self::TYPE_NEARBY_ACCESS;

    public static $fields = [
        'shrine',
        'shopping',
        'hospital',
        'metro',
        'laundry',
        'airport',
        'gas',
        'restaurant',
        'bank',
    ];

    public static $iconsName = [
        'shrine' => 'imam-reza.png',
        'shopping' => 'shoping.png',
        'hospital' => 'hospital.png',
        'metro' => 'metro.png',
        'laundry' => 'laundry.png',
        'airport' => 'airport.png',
        'gas' => 'gas.png',
        'bank' => 'bank.png',
        'restaurant' => 'resturant.png',
    ];

    public function init()
    {
        parent::init();

        $dyna_fields = [];
        foreach (self::$fields as $field) {
            $dyna_fields[$field . '_link'] = ['CHAR', '']; // field values is link of google nearby searches
            $dyna_fields[$field . '_distance'] = ['CHAR', '']; // field values is KM distance
        }

        $this->dynaDefaults = array_merge($this->dynaDefaults, $dyna_fields, [
            // other dyna fields
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $dyna_string_rules = [];
        $dyna_integer_rules = [];
        foreach (self::$fields as $field) {
            $dyna_string_rules[] = $field . '_link';
            $dyna_integer_rules[] = $field . '_distance';
        }
        return array_merge(parent::rules(), [
            ['type', 'default', 'value' => self::$typeName],
            [$dyna_string_rules, 'string'],
            [$dyna_integer_rules, 'string']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'shrine_link' => trans('words', 'Shrine link'),
            'shopping_link' => trans('words', 'Shopping link'),
            'hospital_link' => trans('words', 'Hospital link'),
            'metro_link' => trans('words', 'Metro link'),
            'laundry_link' => trans('words', 'Laundry link'),
            'airport_link' => trans('words', 'Airport link'),
            'gas_link' => trans('words', 'Gas link'),
            'bank_link' => trans('words', 'Bank link'),
            'restaurant_link' => trans('words', 'Restaurant link'),
            'shrine_distance' => trans('words', 'Shrine distance'),
            'shopping_distance' => trans('words', 'Shopping distance'),
            'hospital_distance' => trans('words', 'Hospital distance'),
            'metro_distance' => trans('words', 'Metro distance'),
            'laundry_distance' => trans('words', 'Laundry distance'),
            'airport_distance' => trans('words', 'Airport distance'),
            'gas_distance' => trans('words', 'Gas station distance'),
            'bank_distance' => trans('words', 'Bank distance'),
            'restaurant_distance' => trans('words', 'Restaurant distance'),

            // in show page
            'shrine' => trans('words', 'IMAM REZA shrine'),
            'shopping'=> trans('words', 'shopping'),
            'hospital'=> trans('words', 'hospital'),
            'metro'=> trans('words', 'metro'),
            'laundry'=> trans('words', 'laundry'),
            'airport'=> trans('words', 'Airport'),
            'gas'=> trans('words', 'gas'),
            'bank'=> trans('words', 'bank'),
            'restaurant'=> trans('words', 'Restaurant'),
        ]);
    }

    public function formAttributes()
    {
        $dyna_string_rules = [];
        $dyna_integer_rules = [];
        foreach (self::$fields as $field) {
            $dyna_string_rules[] = $field . '_link';
            $dyna_integer_rules[] = $field . '_distance';
        }
        return array_merge(parent::formAttributes(), [
            [$dyna_string_rules, self::FORM_FIELD_TYPE_TEXT],
            'sep2' => [
                'type' => self::FORM_SEPARATOR,
                'containerCssClass' => 'col-sm-12'
            ],
            [$dyna_integer_rules,[
                'type' =>  self::FORM_FIELD_TYPE_TEXT,
                'hint' => 'بر حسب کیلومتر',
                'containerCssClass' => 'col-sm-3'
            ]],
        ]);
    }


    /**
     * @inheritDoc
     */
    public function render(View $view, $project)
    {
        /** @var $project Project */
        return $view->render('//block/_nearby_access_view', ['block' => $this]);
    }

    public function getDistance($field)
    {
        $value = (float)$this->{$field . '_distance'} < 1?(int)(1000 * (float)$this->{$field . '_distance'}):$this->{$field . '_distance'};
        $text = (float)$this->{$field . '_distance'} < 1?'About {value} meters distance':'About {value} km distance';
        return trans('words', $text, ['value' => $value]);
    }
}