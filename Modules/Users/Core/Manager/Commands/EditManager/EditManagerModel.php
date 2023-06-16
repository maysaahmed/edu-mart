<?php

namespace Modules\Users\Core\Manager\Commands\EditManager;
use Spatie\LaravelData\Data;

class EditManagerModel extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public int $isActive,
        public int $updatedBy,
        public ?string $password = null,
    ) {
    }

}
