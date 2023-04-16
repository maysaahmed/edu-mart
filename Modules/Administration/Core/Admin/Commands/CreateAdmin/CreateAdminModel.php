<?php

namespace Modules\Administration\Core\Admin\Commands\CreateAdmin;
use Spatie\LaravelData\Data;

class CreateAdminModel extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
}
