<?php

namespace app\models\blocks;

use app\models\Block;
use app\models\Project;
use app\models\projects\Apartment;
use app\models\Unit;
use yii\web\View;

/**
 * This class only use in units page
 *
 */
class UnitDetails implements BlockInterface
{
    /** @var Unit $unit */
    private $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;
    }

    /**
     * @inheritDoc
     */
    public function render(View $view, $project = null)
    {
        return $view->render('//block/_unit_details_view', ['block' => $this]);
    }

    /**
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }
}