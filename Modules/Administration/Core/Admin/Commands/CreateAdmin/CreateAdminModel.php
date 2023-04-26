<?php

namespace Modules\Administration\Core\Admin\Commands\CreateAdmin;
use App\Enums\EnumUserTypes;
use Spatie\LaravelData\Data;

class CreateAdminModel extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public int $type,
        public int $roleId,
        public int $createdBy,
        public int $isActive,
    ) {
    }
}
