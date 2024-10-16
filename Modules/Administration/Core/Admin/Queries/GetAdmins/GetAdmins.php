<?php
namespace Modules\Administration\Core\Admin\Queries\GetAdmins;

use Illuminate\Support\Collection;
use Modules\Administration\Core\Admin\Repositories\IAdminRepository;


class GetAdmins implements IGetAdmins
{
    public function __construct(
        private IAdminRepository $repository
    )
    {
    }

    public function execute(): Collection
    {
        return $this->repository->getAdmins();
    }
}
