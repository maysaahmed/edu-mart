<?php

namespace Modules\Courses\Core\Course\Commands\EditCourse;
use Spatie\LaravelData\Data;

class EditCourseModel extends Data
{

    public function __construct(
        public int $id,
        public string $title,
        public int $duration,
        public float $price,
        public ?string $desc = '',
        public array $factors,
        public ?int $level_id = null,
        public ?int $provider_id = null,
        public ?int $category_id =null,
        public ?string $location = null,

    ) {
    }

}
