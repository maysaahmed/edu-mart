<?php
namespace Modules\Administration\Core\Admin\Commands\CreateAdmin;

use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use Modules\Administration\Domain\Entities\Admin\Admin;

class CreateAdmin implements ICreateAdmin
{
    private IAdminRepository $repository;

    public function __construct(IAdminRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateAdminModel $model): Admin
    {
        return $this->repository->createAdmin($model);
    }
}
