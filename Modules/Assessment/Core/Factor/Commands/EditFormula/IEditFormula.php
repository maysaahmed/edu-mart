<?php

namespace Modules\Assessment\Core\Factor\Commands\EditFormula;

use Modules\Assessment\Domain\Entities\Factor;

interface IEditFormula
{
    public function execute(EditFormulaModel $model): bool;
}
