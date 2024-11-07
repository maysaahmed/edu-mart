<?php
namespace Modules\Courses\Core\Course\Queries\GetCourses;
use Spatie\LaravelData\Data;

class GetCoursesModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $title = null,
        public ?string $price = null,
        public ?string $duration = null,
    ) {
    }

}
