<?php


namespace app\components;

interface FormRendererDefinition
{
    const FORM_JS_SCRIPT = -3;
    const FORM_PARAGRAPH = -2;
    const FORM_HEADER = -1;
    const FORM_SEPARATOR = 0;
    const FORM_FIELD_TYPE_TEXT = 1;
    const FORM_FIELD_TYPE_TEXT_AREA = 2;
    const FORM_FIELD_TYPE_SWITCH = 3;
    const FORM_FIELD_TYPE_SELECT = 4;
    const FORM_FIELD_TYPE_CHECKBOX_LIST = 5;
    const FORM_FIELD_TYPE_RADIO_LIST = 6;
    const FORM_FIELD_TYPE_CHECKBOX = 7;
    const FORM_FIELD_TYPE_RADIO = 8;
    const FORM_FIELD_TYPE_TEXT_EDITOR = 9;
    const FORM_FIELD_TYPE_DROP_ZONE = 10;
    const FORM_FIELD_TYPE_DATETIME = 11;
    const FORM_FIELD_TYPE_DATE = 12;
    const FORM_FIELD_TYPE_TIME = 13;
    const FORM_FIELD_TYPE_TAG = 14;
    const FORM_FIELD_TYPE_PASSWORD = 15;
    const FORM_FIELD_TYPE_LANGUAGE_SELECT = 16;
    const FORM_FIELD_TYPE_NUMBER = 17;

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
    public function formAttributes();
}