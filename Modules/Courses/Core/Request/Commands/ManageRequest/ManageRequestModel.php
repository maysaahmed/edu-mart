<?php

namespace Modules\Courses\Core\Request\Commands\ManageRequest;
use Spatie\LaravelData\Data;

class ManageRequestModel extends Data
{
    public function __construct(
        public int $id,
        public int $status,
        public ?string $note = '',
    ) {
    }
}
