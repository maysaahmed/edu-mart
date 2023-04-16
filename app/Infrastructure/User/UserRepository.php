<?php

namespace App\Infrastructure\User;

use App\Core\User\Commands\CreateUser\CreateUserModel;
use App\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use App\Core\User\Repositories\IUserRepository;
use App\Domain\Entities\User\User;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;

class UserRepository extends Repository implements IUserRepository
{
    protected function model(): string
    {
        return User::class;
    }

    public function getUsersPagination(GetUserPaginationModel $model): LengthAwarePaginator
    {
        return QueryBuilder::for(User::class)
            ->allowedFilters('name')
            ->paginate();
//
//        if ($model->name) {
//            $this->addCriteria(new NameCriteria($model->name));
//        }
//
//        $this->addCriteria(new OrderByLatest());
//        return $this->paginator(50, $model->page);
    }

    public function createUser(CreateUserModel $model): User
    {
        $user = new User();
        $user->name = $model->name;
        $user->email = $model->email;
        $user->password = bcrypt($model->password);
        $user->save();

        return $user;
    }
}
