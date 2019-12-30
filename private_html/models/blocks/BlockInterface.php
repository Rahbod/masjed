<?php


namespace app\models\blocks;


use yii\web\View;

interface BlockInterface
{
    /**
     * @param View $view
     * @param $project
     * @return mixed
     */
    public function render(View $view, $project);
}