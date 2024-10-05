<?php
namespace Modules\Assessment\Core\Result\Commands\CreateResult;


use Modules\Assessment\Core\Result\Repositories\IQuestionRepository;
use Modules\Assessment\Domain\Entities\Result;

class CreateResult implements ICreateResult
{
    private IResultRepository $repository;

    public function __construct(IResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(Array $questions): bool
    {

        $updatedItem = $this->repository->reorderQuestions($questions);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Questions failed to order!');
    }
}
