<?php

namespace App\Infrastructure\User;

use App\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use App\Core\User\Repositories\IUserRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class UserRepository extends Repository implements IUserRepository
{
    protected function model(): string
    {
        return User::class;
    }

    public function getUsersPagination(GetUserPaginationModel $model): LengthAwarePaginator
    {
        if ($model->name) {
            $this->addCriteria(new NameCriteria($model->name));
        }

        $this->addCriteria(new OrderByLatest());
        return $this->paginator(50, $model->page);
    }
}
