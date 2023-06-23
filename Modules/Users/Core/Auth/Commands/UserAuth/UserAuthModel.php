<?php

namespace Modules\Users\Core\Auth\Commands\UserAuth;

use Spatie\LaravelData\Data;


class UserAuthModel extends Data
{
     public function __construct(
        public string $email,
        public string $password,
    ) {
    }

}
