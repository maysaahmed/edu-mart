<?php

namespace Modules\Assessment\Core\Factor\Commands\EditFactor;

use Modules\Assessment\Domain\Entities\Factor;

interface IEditFactor
{
    public function execute(EditFactorModel $model): Factor;
}
