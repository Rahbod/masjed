<?php

namespace app\models\blocks;

use app\models\Block;
use app\models\Project;
use app\models\projects\Apartment;
use app\models\projects\Investment;
use app\models\projects\OtherConstruction;
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
        switch ($project->type){
            case Project::TYPE_INVESTMENT:
                $projects = Investment::find()->andWhere(['!=','id', $project->id])->limit(10)->all();
                break;
            case Project::TYPE_OTHER_CONSTRUCTION:
                $projects = OtherConstruction::find()->andWhere(['!=','id', $project->id])->limit(10)->all();
                break;
            default:
                $projects = Apartment::find()->andWhere(['!=','id', $project->id])->limit(10)->all();
        }

        return $view->render('//block/_related_projects_view', ['block' => $this, 'projects' => $projects, 'project' => $project]);
    }
}