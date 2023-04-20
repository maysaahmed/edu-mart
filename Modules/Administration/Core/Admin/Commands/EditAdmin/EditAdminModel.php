<?php

namespace Modules\Administration\Core\Admin\Commands\EditAdmin;
use Spatie\LaravelData\Data;

class EditAdminModel extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password,
        public int $roleId,
        public int $isActive,
        public int $updatedBy,
    ) {
    }

}
