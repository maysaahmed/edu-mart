<?php

namespace Modules\Courses\Core\Level\Commands\EditLevel;
use Spatie\LaravelData\Data;

class EditLevelModel extends Data
{

    public function __construct(
        public int $id,
        public string $name,
    ) {
    }

}
