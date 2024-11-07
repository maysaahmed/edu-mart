<?php
namespace Modules\Courses\Core\Course\Queries\GetArchivedCourses;
use Spatie\LaravelData\Data;

class GetArchivedCoursesModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $title = null,
    ) {
    }

}
