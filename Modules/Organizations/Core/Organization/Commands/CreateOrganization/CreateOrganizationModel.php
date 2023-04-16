<?php

namespace Modules\Organizations\Core\Organization\Commands\CreateOrganization;
use Spatie\LaravelData\Data;

class CreateOrganizationModel extends Data
{
    public function __construct(
        public string $name,
        public string $phone,
        public string $address,
    ) {
    }
}
