<?php
namespace Modules\Users\Core\Manager\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Core\Manager\Queries\GetManagerPagination\GetManagerPaginationModel;
use Modules\Users\Domain\Entities\Manager;
use Illuminate\Database\Eloquent\Collection;

interface IManagerRepository extends IRepository
{
    public function getManagerById($id): Manager|null;
    public function getOrganizationManagers($org_id): Collection;
    public function getManagersPagination(GetManagerPaginationModel $model): LengthAwarePaginator;
}
