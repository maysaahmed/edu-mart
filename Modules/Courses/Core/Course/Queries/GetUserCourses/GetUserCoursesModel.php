<?php
namespace Modules\Courses\Core\Course\Queries\GetUserCourses;
use Spatie\LaravelData\Data;

class GetUserCoursesModel extends Data
{

    public function __construct(
        public string $status = 'all',
        public ?int $organization_id = null,
    ) {
    }

}
