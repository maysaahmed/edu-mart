<?php

namespace Modules\Administration\Core\Admin\Commands\EditProfile;
use Spatie\LaravelData\Data;

class EditProfileModel extends Data
{
    public function __construct(
        public int $profileId,
        public string $name,
        public string $email
    ) {
    }

}
