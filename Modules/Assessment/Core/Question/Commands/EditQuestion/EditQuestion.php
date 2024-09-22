<?php
namespace Modules\Assessment\Core\Question\Commands\EditQuestion;

use Modules\Assessment\Core\Question\Repositories\IQuestionRepository;
use Modules\Assessment\Domain\Entities\Question;

class EditQuestion implements IEditQuestion
{
    private IQuestionRepository $repository;

    public function __construct(IQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditQuestionModel $model): Question
    {
        $item =$this->repository->getQuestionById($model->id);

        if(!$item){
            throw new \Exception('Question cannot be found!');
        }

        $updatedItem = $this->repository->editQuestion($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Question failed to update!');
    }
}
