<?php
namespace Modules\Organizations\Infrastructure\Organization;

use Modules\Organizations\Core\Organization\Commands\CreateOrganization\CreateOrganizationModel;
use Modules\Organizations\Core\Organization\Commands\EditOrganization\EditOrganizationModel;
use Modules\Organizations\Core\Organization\Queries\GetOrganizationPagination\GetOrganizationPaginationModel;
use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Organizations\Domain\Entities\Organization\Organization;
use Spatie\QueryBuilder\QueryBuilder;

class OrganizationRepository extends Repository implements IOrganizationRepository
{
    protected function model(): string
    {
        return Organization::class;
    }

    public function getOrganizationById($id): Organization
    {
        return Organization::find($id);
    }

    public function getOrganizationsPagination(GetOrganizationPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Organization::class)
            ->allowedFilters('name', 'phone', 'address')
            ->paginate();
    }

    public function createOrganization(CreateOrganizationModel $model): Organization
    {
        $org = new Organization();
        $org->name = $model->name;
        $org->phone = $model->phone;
        $org->address = $model->address;
        $org->save();

        return $org;
    }

    public function editOrganization(EditOrganizationModel $model): Organization|null
    {
        $id = $model->id;
        $item = $this->getOrganizationById($id);

        if($item){

            $item->name = $model->name;
            $item->phone = $model->phone;
            $item->address = $model->address;
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }

    public function deleteOrganization(int $id): bool
    {
        $item = $this->getOrganizationById($id);
        return  $item && $item->delete();
    }
}
