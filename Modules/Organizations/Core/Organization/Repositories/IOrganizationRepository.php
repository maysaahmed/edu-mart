<?php
namespace Modules\Organizations\Core\Organization\Repositories;

use App\Core\Repository\IRepository;
use Modules\Organizations\Core\Organization\Commands\CreateOrganization\CreateOrganizationModel;
use Modules\Organizations\Core\Organization\Commands\EditOrganization\EditOrganizationModel;
use Modules\Organizations\Core\Organization\Queries\GetOrganizationPagination\GetOrganizationPaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Organizations\Domain\Entities\Organization\Organization;
use Illuminate\Database\Eloquent\Collection;

interface IOrganizationRepository extends IRepository
{
    public function getOrganizationById($id): Organization|null;
    public function getOrganizationsPagination(GetOrganizationPaginationModel $model): LengthAwarePaginator;
    public function getOrganizationList(): Collection;
    public function createOrganization(CreateOrganizationModel $model): Organization;
    public function editOrganization(EditOrganizationModel $model): Organization|null;
    public function deleteOrganization(int $id): bool;
    public function importOrganizations(string $file_path): int;
    public function editOrganizationStatus(EditOrganizationStatusModel $model): Organization|null;
}
