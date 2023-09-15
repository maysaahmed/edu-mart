<?php
namespace Modules\Courses\Core\Course\Queries\GetUserCoursesPagination;
use Spatie\LaravelData\Data;

class GetUserCoursesPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public string $status = 'all',
        public ?int $organization_id = null,
        public ?string $title = null,
        public ?string $price_min = null,
        public ?string $price_max = null,
        public ?string $provider_id = null,
        public ?string $category_id = null,
        public ?string $level_id = null,
        public ?string $location= null,
        public ?string $sorts= null,
    ) {
    }

}
