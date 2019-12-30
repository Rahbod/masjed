<?php

namespace app\models\blocks;

use app\models\Block;
use app\models\Project;
use yii\web\View;

/**
 * This is the model class for table "item".
 *
 */
class Units implements BlockInterface
{
    /**
     * @inheritDoc
     */
    public function render(View $view, $project)
    {
        /** @var $project Project */
        return $view->render('//block/_units_view', ['block' => $this, 'project' => $project]);
    }
}