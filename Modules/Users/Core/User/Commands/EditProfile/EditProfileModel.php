<?php

namespace Modules\Users\Core\User\Commands\EditProfile;
use Spatie\LaravelData\Data;

class EditProfileModel extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $gender,
        public string $dob,
        public int $graduated,
        public ?string $education = null,
        public ?string $university = null,
        public ?string $industry = null,
        public ?string $area = null,
        public ?string $phone = null,
        public ?string $image = null,

    ) {
    }

}
