<?php
namespace Modules\Users\Core\Manager\Queries\GetManagerPagination;
use Spatie\LaravelData\Data;

class GetManagerPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $name = null,
        public ?string $email = null,
        public ?string $organization = null
    ) {
    }

}
