<?php

namespace app\models\blocks;

use app\models\Block;
use app\models\Project;
use app\models\Unit;
use yii\web\View;

/**
 * This class only use in units page
 *
 */
class OtherUnits implements BlockInterface
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
        /** @var $project Project */
        $units = Unit::find()
            ->andWhere([Unit::columnGetString('itemID') => $this->unit->itemID])
            ->andWhere(['!=', 'id', $this->unit->id])
            ->all();

        return $view->render('//block/_other_units_view', ['block' => $this, 'units' => $units]);
    }

    /**
     * @return Unit
     */
    public function getUnit()
    {
        return $this->unit;
    }
}