<?php

namespace Modules\Administration\Core\Admin\Commands\UpdateAdminStatus;
use Spatie\LaravelData\Data;

class UpdateAdminStatusModel extends Data
{
    public function __construct(
        public int $id,
        public string $status,
        public int $updatedBy,
    ) {
    }

}
