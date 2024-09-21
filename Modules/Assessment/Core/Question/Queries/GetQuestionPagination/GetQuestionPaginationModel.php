<?php
namespace Modules\Assessment\Core\Question\Queries\GetQuestionPagination;
use Spatie\LaravelData\Data;

class GetQuestionPaginationModel extends Data
{

    public function __construct(
        public int $page = 1,
        public ?string $ques = null,
        public ?string $order = null,
    ) {
    }

}
