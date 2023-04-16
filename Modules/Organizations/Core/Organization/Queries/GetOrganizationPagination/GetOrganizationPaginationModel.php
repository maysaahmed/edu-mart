<?php
namespace Modules\Organizations\Core\Organization\Queries\GetOrganizationPagination;
use Spatie\LaravelData\Data;

class GetOrganizationPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $name = null,
        public ?string $phone = null,
        public ?string $address = null,
        public int $status = 1
    ) {
    }

}
