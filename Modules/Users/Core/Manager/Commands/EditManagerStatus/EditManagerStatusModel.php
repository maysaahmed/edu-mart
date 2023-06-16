<?php

namespace Modules\Users\Core\Manager\Commands\EditManagerStatus;
use Spatie\LaravelData\Data;

class EditManagerStatusModel extends Data
{

    public function __construct(
        public int $id,
        public int $isActive,
    ) {
    }

}
