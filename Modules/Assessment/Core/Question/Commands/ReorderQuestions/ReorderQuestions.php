<?php
namespace Modules\Assessment\Core\Question\Commands\ReorderQuestions;


use Modules\Assessment\Core\Question\Repositories\IQuestionRepository;
use Modules\Assessment\Domain\Entities\Question;

class ReorderQuestions implements IReorderQuestions
{
    private IQuestionRepository $repository;

    public function __construct(IQuestionRepository $repository)
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
