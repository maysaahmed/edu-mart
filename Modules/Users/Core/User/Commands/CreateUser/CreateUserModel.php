<?php

namespace Modules\Users\Core\User\Commands\CreateUser;
use Spatie\LaravelData\Data;

class CreateUserModel extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public int $organizationId,
        public int $createdBy,
        public int $isActive,
    ) {
    }

}
