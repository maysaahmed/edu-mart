<?php
namespace Modules\Courses\Core\Provider\Queries\GetProviderPagination;
use Spatie\LaravelData\Data;

class GetProviderPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $name = null,

    ) {
    }

}
