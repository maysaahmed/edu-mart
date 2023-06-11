<?php
namespace Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination;
use Spatie\LaravelData\Data;

class GetOrganizationRequestsPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?int $org_id = null,
        public ?string $user_name = null,
    ) {
    }

}
