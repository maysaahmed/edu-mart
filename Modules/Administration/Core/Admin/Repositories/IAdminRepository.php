<?php
namespace Modules\Administration\Core\Admin\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Administration\Core\Admin\Queries\GetAdminPagination\GetAdminPaginationModel;
use Modules\Administration\Domain\Entities\Admin\Admin;

interface IAdminRepository extends IRepository
{
    public function getAdminByEmail(string $email): Admin|null;
    public function getAdminByID(int $id): Admin|null;
    public function getAdminsPagination(int $page, ?string $name = null, ?string $email = null): LengthAwarePaginator;
    public function createAdmin(string $name, string $email, string $password, int $type, int $roleId, int $createdBy, int $isActive): Admin;
    public function editAdmin(int $id, string $name, string $email, ?string $password, int $roleId, int $status, int $updatedBy): Admin|null;
    public function updateAdminStatus(int $id,int $isActive, int $updatedBy): Admin|null;
    public function deleteAdmin(int $id, int $deletedBy): bool;
    public function editProfile(int $profileId, string $name, string $email): Admin|null;
    public function ChangePassword(int $profileId, string $password): Admin|null;
}
