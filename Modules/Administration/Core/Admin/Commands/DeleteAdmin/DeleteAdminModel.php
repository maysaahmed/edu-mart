<?php

namespace Modules\Administration\Core\Admin\Commands\DeleteAdmin;
use Spatie\LaravelData\Data;

class DeleteAdminModel extends Data
{
    public function __construct(
        public int $id,
        public int $deletedBy,
    ) {
    }

}
