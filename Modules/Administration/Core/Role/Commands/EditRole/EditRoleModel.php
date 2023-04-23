<?php

namespace Modules\Administration\Core\Role\Commands\EditRole;
use Spatie\LaravelData\Data;

class EditRoleModel extends Data
{

    public function __construct(
        public int $id,
        public array $permissions,
    ) {
    }

}
