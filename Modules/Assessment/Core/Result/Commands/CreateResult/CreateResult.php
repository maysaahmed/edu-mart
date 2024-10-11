<?php
namespace Modules\Assessment\Core\Result\Commands\CreateResult;


use Illuminate\Support\Collection;
use Modules\Assessment\Core\Result\Repositories\IResultRepository;



class CreateResult implements ICreateResult
{
    private IResultRepository $repository;

    public function __construct(IResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(Array $answers): Collection|bool
    {
        //check if user took the assessment before
        $result = $this->repository->getResults(auth()->id());

        if(count($result) != 0)
            throw new \Exception('you have taken this assessment before!');

        $saved = $this->repository->createResults($answers);
        if ($saved){
            return $saved;
        }

        throw new \Exception('results failed to saved!');
    }
}
