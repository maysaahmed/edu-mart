<?php

namespace Modules\Users\Core\User\Commands\RegisterUser;
use Spatie\LaravelData\Data;

class RegisterUserModel extends Data
{
    public function __construct(
        public string $first_name,
        public string $last_name,
        public string $email,
        public string $password,


    ) {
    }

}
