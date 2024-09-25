<?php
namespace Modules\Assessment\Core\Question\Queries\GetQuestions;

use Modules\Assessment\Core\Question\Repositories\IQuestionRepository;
use Illuminate\Support\Collection;

class GetQuestions implements IGetQuestions
{
    private IQuestionRepository $repository;

    public function __construct(IQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getQuestions();
    }
}
