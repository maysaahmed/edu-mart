<?php
namespace Modules\Courses\Infrastructure\Provider;

use Illuminate\Support\Collection;
use Modules\Courses\Core\Provider\Commands\EditProvider\EditProviderModel;
use Modules\Courses\Core\Provider\Queries\GetProviderPagination\GetProviderPaginationModel;
use Modules\Courses\Core\Provider\Repositories\IProviderRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Provider;
use Spatie\QueryBuilder\QueryBuilder;
use Modules\Courses\Infrastructure\Provider\Imports\ImportProviders;

class ProviderRepository extends Repository implements IProviderRepository
{
    protected function model(): string
    {
        return Provider::class;
    }

    public function getProviderById($id): Provider|null
    {
        return Provider::find($id);
    }

    public function getProvidersPagination(GetProviderPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Provider::class)
            ->allowedFilters('name')
            ->paginate();
    }

    public function createProvider(string $name): Provider
    {
        $pro = new Provider();
        $pro->name = $name;
        $pro->save();

        return $pro;
    }

    public function editProvider(EditProviderModel $model): Provider|null
    {
        $id = $model->id;
        $item = $this->getProviderById($id);

        if($item){

            $item->name = $model->name;
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }

    public function deleteProvider(int $id): bool
    {
        $item = $this->getProviderById($id);
        return  $item && $item->delete();
    }

    public function importProviders($file_path): int
    {

        $import = new ImportProviders;
        $import->import($file_path);
        return $import->getRowCount();

    }

    public function getProviders(): Collection
    {
        return Provider::all();
    }
}
