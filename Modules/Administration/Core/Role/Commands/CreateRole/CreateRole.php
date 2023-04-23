<?php
namespace Modules\Administration\Core\Role\Commands\CreateRole;

use Modules\Administration\Core\Role\Repositories\IRoleRepository;
use Spatie\Permission\Models\Role;

class CreateRole implements ICreateRole
{
    private IRoleRepository $repository;

    public function __construct(IRoleRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $name): Role
    {
        return $this->repository->createRole($name);
    }
}
