<?php
namespace Modules\Users\Core\User\Queries\GetUserPagination;
use Spatie\LaravelData\Data;

class GetUserPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?int $org_id = null,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $created_by = null,
    ) {
    }

}
