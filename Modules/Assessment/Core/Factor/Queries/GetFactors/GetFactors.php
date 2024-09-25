<?php
namespace Modules\Assessment\Core\Factor\Queries\GetFactors;

use Modules\Assessment\Core\Factor\Repositories\IFactorRepository;
use Illuminate\Support\Collection;

class GetFactors implements IGetFactors
{
    private IFactorRepository $repository;

    public function __construct(IFactorRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getFactors();
    }
}
