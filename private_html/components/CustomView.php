<?php


namespace app\components;


use yii\web\View;

class CustomView extends View
{
    public function beforeRender($viewFile, $params)
    {
        return parent::beforeRender($viewFile, $params); // TODO: Change the autogenerated stub
    }
}