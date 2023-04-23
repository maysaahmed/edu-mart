<?php

namespace Modules\Organizations\Core\Organization\Commands\EditOrganization;
use Spatie\LaravelData\Data;

class EditOrganizationModel extends Data
{

    public function __construct(
        public int $id,
        public string $name,
        public ?string $phone = null,
        public ?string $address =null,
        public ?int $status = 1,
    ) {
    }

}
