<?php

namespace Modules\Users\Core\User\Commands\EditProfile;
use Spatie\LaravelData\Data;

class EditProfileModel extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $gender,
        public string $dob,
        public int $graduated,
        public string $education,
        public string $university,
        public string $industry,
        public string $area,
        public string $phone,
        public ?string $image = null,

    ) {
    }

}
