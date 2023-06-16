<?php

namespace Modules\Users\Core\User\Commands\EditUser;
use Spatie\LaravelData\Data;

class EditUserModel extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public int $isActive,
        public int $updatedBy,
        public ?string $password = null,
    ) {
    }

}
