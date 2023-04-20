<?php

namespace Modules\Administration\Core\Admin\Commands\ChangePassword;
use Spatie\LaravelData\Data;

class ChangePasswordModel extends Data
{
    public function __construct(
        public int $profileId,
        public string $oldPassword,
        public string $newPassword,
    ) {
    }

}
