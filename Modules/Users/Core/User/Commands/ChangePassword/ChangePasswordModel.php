<?php

namespace Modules\Users\Core\User\Commands\ChangePassword;
use Spatie\LaravelData\Data;

class ChangePasswordModel extends Data
{
    public function __construct(
        public int $id,
        public string $oldPass,
        public string $newPass
    ) {
    }

}
