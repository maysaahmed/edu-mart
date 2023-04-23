<?php
namespace Modules\Courses\Core\Level\Queries\GetLevelPagination;
use Spatie\LaravelData\Data;

class GetLevelPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $name = null,

    ) {
    }

}
