<?php
namespace Modules\Assessment\Core\Result\Commands\CreateResult;


use Modules\Assessment\Core\Result\Repositories\IResultRepository;


class CreateResult implements ICreateResult
{
    private IResultRepository $repository;

    public function __construct(IResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(Array $answers): bool
    {

        $saved = $this->repository->createResults($answers);
        if ($saved){
            return $saved;
        }

        throw new \Exception('results failed to saved!');
    }
}
