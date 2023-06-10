<?php

namespace Modules\Courses\Core\Request\Commands\CreateRequest;
use Spatie\LaravelData\Data;

class CreateRequestModel extends Data
{
    public function __construct(
        public int $user_id,
        public int $course_id,
    ) {
    }
}
