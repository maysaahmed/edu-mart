<?php

namespace App\Core\User\Queries\GetUserPagination;

use App\Core\User\Repositories\IUserRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetUserPagination implements IGetUserPagination
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GetUserPaginationModel $model): LengthAwarePaginator
    {
        return $this->repository->getUsersPagination($model);
    }
}
