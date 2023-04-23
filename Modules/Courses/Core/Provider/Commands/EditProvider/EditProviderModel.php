<?php

namespace Modules\Courses\Core\Provider\Commands\EditProvider;
use Spatie\LaravelData\Data;

class EditProviderModel extends Data
{

    public function __construct(
        public int $id,
        public string $name,
    ) {
    }

}
