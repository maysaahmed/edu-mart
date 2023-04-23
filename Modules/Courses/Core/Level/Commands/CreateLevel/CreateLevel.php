<?php
namespace Modules\Courses\Core\Level\Commands\CreateLevel;

use Modules\Courses\Core\Level\Repositories\ILevelRepository;
use Modules\Courses\Domain\Entities\Level;

class CreateLevel implements ICreateLevel
{
    private ILevelRepository $repository;

    public function __construct(ILevelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name): Level
    {
        return $this->repository->createLevel($name);
    }
}
