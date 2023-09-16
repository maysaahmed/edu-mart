<?php

namespace Modules\Users\Core\User\Commands\CompleteUserData;
use Spatie\LaravelData\Data;

class CompleteUserDataModel extends Data
{
    public function __construct(
        public int $user_id,
        public ?string $name = null,
        public ?string $jobTitle = null,
        public ?string $area = null,
        public ?string $DOB = null,
        public ?string $gender = null,
    ) {
    }

}
