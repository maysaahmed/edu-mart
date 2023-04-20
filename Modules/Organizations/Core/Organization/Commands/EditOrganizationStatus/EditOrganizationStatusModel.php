<?php

namespace Modules\Organizations\Core\Organization\Commands\EditOrganizationStatus;
use Spatie\LaravelData\Data;

class EditOrganizationStatusModel extends Data
{

    public function __construct(
        public int $id,
        public int $status,
    ) {
    }

}
