<?php
namespace Modules\Courses\Core\Provider\Commands\CreateProvider;

use Modules\Courses\Core\Provider\Repositories\IProviderRepository;
use Modules\Courses\Domain\Entities\Provider;

class CreateProvider implements ICreateProvider
{
    private IProviderRepository $repository;

    public function __construct(IProviderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name): Provider
    {
        return $this->repository->createProvider($name);
    }
}
