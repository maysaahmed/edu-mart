<?php
namespace Modules\Courses\Core\Provider\Queries\GetProviders;

use Modules\Courses\Core\Provider\Repositories\IProviderRepository;
use Illuminate\Support\Collection;

class GetProviders implements IGetProviders
{
    private IProviderRepository $repository;

    public function __construct(IProviderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getProviders();
    }
}
