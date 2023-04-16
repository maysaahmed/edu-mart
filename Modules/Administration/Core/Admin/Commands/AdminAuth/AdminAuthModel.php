<?php

namespace Modules\Administration\Core\Admin\Commands\AdminAuth;
use Spatie\LaravelData\Data;

class AdminAuthModel extends Data
{
     public function __construct(
        public string $email,
        public string $password,
    ) {
    }
    
}
