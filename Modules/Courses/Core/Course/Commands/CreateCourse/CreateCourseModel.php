<?php

namespace Modules\Courses\Core\Course\Commands\CreateCourse;
use Spatie\LaravelData\Data;

class CreateCourseModel extends Data
{
    public function __construct(
        public string $title,
        public int $duration,
        public float $price,
        public ?string $desc = '',
        public ?int $level_id = null,
        public ?int $provider_id = null,
        public ?int $category_id =null,
        public ?string $location = null,
    ) {
    }
}
