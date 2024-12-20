<?php
namespace Modules\Users\Core\User\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Database\Eloquent\Collection;
use Modules\Users\Core\User\Commands\CompleteUserData\CompleteUserDataModel;
use Modules\Users\Core\User\Commands\CreateUser\CreateUserModel;
use Modules\Users\Core\User\Commands\RegisterUser\RegisterUserModel;
use Modules\Users\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Domain\Entities\EndUser;
use Modules\Users\Domain\Entities\PasswordReset;
use Modules\Users\Domain\Entities\VerifyUser;

interface IUserRepository extends IRepository
{
    public function getUserById($id): EndUser|null;
    public function getUserByEmail($email): EndUser|null;
    public function getVerifyUserByToken($token): VerifyUser|null;
    public function getResetByToken($token): PasswordReset|null;
    public function getUsersPagination(GetUserPaginationModel $model): LengthAwarePaginator;
    public function getAllEndUsers(): Collection;

    public function createUser(CreateUserModel $model): EndUser;
    public function editUser(EditUserModel $model): EndUser|null;
    public function completeUserData(CompleteUserDataModel $model): EndUser|null;
    public function deleteUser(int $id, int $deletedBy): bool;
    public function verifyUser(string $token, string $password): bool|null;
    public function verifyRegisteredUser(string $token): bool|null;
    public function resetPassword(string $token, string $password): int|null;
    public function createUserToken($email): string|null;
    public function generateToken(): string;

    public function importUsers(string $file_path): int|null;

    public function registerUser(RegisterUserModel $model): EndUser;

    public function editProfile(EditProfileModel $model): EndUser|null;
    public function changePassword(int $id, string $newPass): EndUser|null;
    public function uploadImage(int $id, string $image): string|null;
    public function removeImage(int $id): bool|null;



}
