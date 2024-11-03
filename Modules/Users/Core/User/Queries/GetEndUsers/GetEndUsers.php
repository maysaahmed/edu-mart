<?php
namespace Modules\Users\Core\User\Queries\GetEndUsers;

use Illuminate\Database\Eloquent\Collection;
use Modules\Users\Core\User\Repositories\IUserRepository;

class GetEndUsers implements IGetEndUsers
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getAllEndUsers();
    }
}
