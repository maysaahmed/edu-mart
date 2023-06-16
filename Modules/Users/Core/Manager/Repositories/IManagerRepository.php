<?php
namespace Modules\Users\Core\Manager\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Core\Manager\Queries\GetManagerPagination\GetManagerPaginationModel;
use Modules\Users\Core\Manager\Commands\EditManager\EditManagerModel;
use Modules\Users\Core\Manager\Commands\EditManagerStatus\EditManagerStatusModel;
use Modules\Users\Domain\Entities\Manager;
use Illuminate\Database\Eloquent\Collection;

interface IManagerRepository extends IRepository
{
    public function getManagerById($id): Manager|null;
    public function getOrganizationManagers($org_id): Collection;
    public function getManagersPagination(GetManagerPaginationModel $model): LengthAwarePaginator;
    public function editManager(EditManagerModel $model): Manager|null;
    public function deleteManager(int $id, int $deletedBy): bool;
    public function editManagerStatus(EditManagerStatusModel $model): Manager|null;

}
