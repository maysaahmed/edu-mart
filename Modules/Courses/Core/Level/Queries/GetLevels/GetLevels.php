<?php
namespace Modules\Courses\Core\Level\Queries\GetLevels;

use Modules\Courses\Core\Level\Repositories\ILevelRepository;
use Illuminate\Support\Collection;

class GetLevels implements IGetLevels
{
    private ILevelRepository $repository;

    public function __construct(ILevelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getLevels();
    }
}
