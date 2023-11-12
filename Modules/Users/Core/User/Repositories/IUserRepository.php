<?php
namespace Modules\Users\Core\User\Repositories;

use App\Core\Repository\IRepository;
use Modules\Users\Core\User\Commands\CompleteUserData\CompleteUserDataModel;
use Modules\Users\Core\User\Commands\CreateUser\CreateUserModel;
use Modules\Users\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Domain\Entities\EndUser;
use Modules\Users\Domain\Entities\VerifyUser;

interface IUserRepository extends IRepository
{
    public function getUserById($id): EndUser|null;
    public function getVerifyUserByToken($token): VerifyUser|null;
    public function getUsersPagination(GetUserPaginationModel $model): LengthAwarePaginator;

    public function createUser(CreateUserModel $model): EndUser;
    public function editUser(EditUserModel $model): EndUser|null;
    public function completeUserData(CompleteUserDataModel $model): EndUser|null;
    public function deleteUser(int $id, int $deletedBy): bool;
    public function verifyUser(string $token, string $password): bool|null;

    public function importUsers(string $file_path): int|null;
}
