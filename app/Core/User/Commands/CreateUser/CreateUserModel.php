<?php

namespace App\Core\User\Commands\CreateUser;
use Spatie\LaravelData\Data;

class CreateUserModel extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {
    }
    
}
