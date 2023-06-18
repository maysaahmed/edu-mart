<?php

namespace Modules\Users\Core\Manager\Commands\CreateManager;
use Spatie\LaravelData\Data;

class CreateManagerModel extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public int $createdBy,
        public int $organization_id,
        public int $type,

    ) {
    }

}
