<?php
namespace Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination;
use Spatie\LaravelData\Data;

class GetOrganizationCoursesPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $title = null,
        public ?string $price = null,
        public ?string $duration = null,
        public ?int $provider_id = null,
        public ?int $level_id = null,
        public ?bool $visibility = null,
    ) {
    }

}
