<?php

namespace Modules\Assessment\Core\Factor\Commands\EditFactor;
use Spatie\LaravelData\Data;

class EditFactorModel extends Data
{

    public function __construct(
        public int $id,
        public string $name_en,
        public string $name_ar,
        public string $desc_en,
        public string $desc_ar,
        public string $low_desc_en,
        public string $low_desc_ar,
        public string $moderate_desc_en,
        public string $moderate_desc_ar,
        public string $high_desc_en,
        public string $high_desc_ar,
        public string $formula,

    ) {
    }

}
