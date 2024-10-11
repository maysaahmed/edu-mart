<?php
namespace Modules\Assessment\Core\Result\Queries\GetResult;

use Modules\Assessment\Core\Result\Repositories\IResultRepository;
use Illuminate\Support\Collection;

class GetResult implements IGetResult
{
    private IResultRepository $repository;

    public function __construct(IResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        $user_id = auth()->id();
        return $this->repository->getResults($user_id);
    }
}
