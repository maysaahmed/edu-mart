<?php

namespace Modules\Assessment\Core\Factor\Commands\EditFormula;
use Spatie\LaravelData\Data;

class EditFormulaModel extends Data
{

    public function __construct(
        public int $id,
        public string $formula,

    ) {
    }

}
