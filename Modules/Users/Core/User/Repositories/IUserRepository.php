<?php
namespace Modules\Users\Core\User\Repositories;

use App\Core\Repository\IRepository;
use Modules\Users\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Domain\Entities\EndUser;

interface IUserRepository extends IRepository
{
    public function getUserById($id): EndUser|null;
    public function getUsersPagination(GetUserPaginationModel $model): LengthAwarePaginator;

    public function createUser(string $name, string $email, string $password, int $organizationId, int $createdBy, int $isActive): EndUser;
    public function editUser(EditUserModel $model): EndUser|null;
    public function deleteUser(int $id, int $deletedBy): bool;

    public function importUsers(string $file_path): int;
}
