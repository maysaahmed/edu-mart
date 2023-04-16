<?php

namespace App\Core\User\Repositories;

use App\Core\User\Commands\CreateUser\CreateUserModel;
use App\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use App\Core\Repository\IRepository;
use App\Domain\Entities\User\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface IUserRepository extends IRepository
{
    public function getUsersPagination(GetUserPaginationModel $model): LengthAwarePaginator;
    public function createUser(CreateUserModel $model): User;

}
