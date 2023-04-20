<?php
namespace Modules\Courses\Core\Course\Queries\GetCoursePagination;
use Spatie\LaravelData\Data;

class GetCoursePaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $title = null,
        public ?string $price = null,
        public ?string $duration = null,
    ) {
    }

}
