<?php

namespace Modules\Assessment\Core\Question\Commands\EditQuestion;
use Spatie\LaravelData\Data;

class EditQuestionModel extends Data
{

    public function __construct(
        public int $id,
        public string $ques_en,
        public string $ques_ar,
        public int $order,
        public int $factor_id,
    ) {
    }

}
