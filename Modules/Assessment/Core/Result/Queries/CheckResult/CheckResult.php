<?php
namespace Modules\Assessment\Core\Result\Queries\CheckResult;

use Modules\Assessment\Core\Result\Repositories\IResultRepository;
use Illuminate\Support\Collection;

class CheckResult implements ICheckResult
{
    private IResultRepository $repository;

    public function __construct(IResultRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): bool
    {
        $user_id = auth()->id();
        return $this->repository->takeAssessment($user_id);
    }
}
