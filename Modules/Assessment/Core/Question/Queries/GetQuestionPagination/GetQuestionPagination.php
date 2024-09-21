<?php
namespace Modules\Assessment\Core\Question\Queries\GetQuestionPagination;

use Modules\Assessment\Core\Question\Repositories\IQuestionRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetQuestionPagination implements IGetQuestionPagination
{
    private IQuestionRepository $repository;

    public function __construct(IQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetQuestionPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getQuestionsPagination($model);
    }
}
