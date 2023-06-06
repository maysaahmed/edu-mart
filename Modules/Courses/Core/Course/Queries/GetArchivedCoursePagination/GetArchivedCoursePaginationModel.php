<?php
namespace Modules\Courses\Core\Course\Queries\GetArchivedCoursePagination;
use Spatie\LaravelData\Data;

class GetArchivedCoursePaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $title = null,
    ) {
    }

}
