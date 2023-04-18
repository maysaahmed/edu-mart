<?php
namespace Modules\Courses\Core\Category\Queries\GetCategoryPagination;
use Spatie\LaravelData\Data;

class GetCategoryPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $name = null,

    ) {
    }

}
