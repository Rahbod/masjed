<?php

namespace app\models\projects;

use yii\web\View;

interface ProjectInterface
{
    /**
     * @param View $view
     * @return string
     */
    public function render(View $view);

    /**
     * @return string
     */
//    public function renderView();
}