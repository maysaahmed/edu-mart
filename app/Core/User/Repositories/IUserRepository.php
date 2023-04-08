<?php

namespace App\Core\User\Repositories;

use App\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use App\Core\Repository\IRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IUserRepository extends IRepository
{
    public function getUsersPagination(GetUserPaginationModel $model): LengthAwarePaginator;
}
