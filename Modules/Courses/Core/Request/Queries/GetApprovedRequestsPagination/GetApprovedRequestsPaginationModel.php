<?php
namespace Modules\Courses\Core\Request\Queries\GetApprovedRequestsPagination;
use Spatie\LaravelData\Data;

class GetApprovedRequestsPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?int $org_name = null,
        public ?string $user_name = null,
        public ?string $course_title = null,
    ) {
    }

}
