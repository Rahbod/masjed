<?php

namespace app\models\blocks;

use app\models\Block;
use app\models\Project;
use app\models\Unit;
use yii\web\View;

/**
 * This is the model class for table "item".
 *
 */
class RelatedProjects implements BlockInterface
{
    /**
     * @inheritDoc
     */
    public function render(View $view, $project)
    {
        /** @var $project Project */
        $projects = Project::find()->andWhere(['!=','id', $project->id])->limit(10)->all();

        return $view->render('//block/_related_projects_view', ['block' => $this, 'projects' => $projects, 'project' => $project]);
    }
}