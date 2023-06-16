<?php
namespace Modules\Users\Infrastructure\Manager;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Core\Manager\Repositories\IManagerRepository;
use App\Infrastructure\Repository\Repository;
use Modules\Users\Core\Manager\Queries\GetManagerPagination\GetManagerPaginationModel;
use Modules\Users\Domain\Entities\EndUser;
use Modules\Users\Domain\Entities\Manager;
use App\Enums\EnumUserTypes;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use DB;

class ManagerRepository extends Repository implements IManagerRepository
{
    protected function model(): string
    {
        return Manager::class;
    }

    public function getManagerById($id): Manager|null
    {
        return Manager::find($id);
    }

    public function getOrganizationManagers($org_id): Collection
    {
        return Manager::where(['organization_id' => $org_id, 'type' => EnumUserTypes::Manager->value])->select('id','name')->get();
    }

    public function getManagersPagination(GetManagerPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Manager::class)
            ->select('users.*',  DB::raw('organizations.name as organization_name') )
            ->join('organizations', 'users.organization_id', '=', 'organizations.id')
            ->where('type', EnumUserTypes::Manager)
            ->allowedFilters('name', 'email', 'organization.name')
            ->paginate();
    }



}
