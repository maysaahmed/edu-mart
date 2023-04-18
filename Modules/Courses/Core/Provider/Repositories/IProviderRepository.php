<?php
namespace Modules\Courses\Core\Provider\Repositories;

use App\Core\Repository\IRepository;
use Modules\Courses\Core\Provider\Queries\GetProviderPagination\GetProviderPaginationModel;
use Modules\Courses\Core\Provider\Commands\EditProvider\EditProviderModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Provider;

interface IProviderRepository extends IRepository
{
    public function getProviderById($id): Provider;
    public function getProvidersPagination(GetProviderPaginationModel $model): LengthAwarePaginator;
    public function createProvider(string $name): Provider;
    public function editProvider(EditProviderModel $model): Provider|null;
    public function deleteProvider(int $id): bool;
    public function importProviders(string $file_path): int;
}
