<?php
namespace Modules\Courses\Infrastructure\Level;

use Modules\Courses\Core\Level\Commands\EditLevel\EditLevelModel;
use Modules\Courses\Core\Level\Queries\GetLevelPagination\GetLevelPaginationModel;
use Modules\Courses\Core\Level\Repositories\ILevelRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Level;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Modules\Courses\Infrastructure\Level\Imports\ImportLevels;

class LevelRepository extends Repository implements ILevelRepository
{
    protected function model(): string
    {
        return Level::class;
    }

    public function getLevelById($id): Level|null
    {
        return Level::find($id);
    }

    public function getLevelsPagination(GetLevelPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Level::class)
            ->allowedFilters('name')
            ->paginate();
    }

    public function createLevel(string $name): Level
    {
        $cat = new Level();
        $cat->name = $name;
        $cat->save();

        return $cat;
    }

    public function editLevel(EditLevelModel $model): Level|null
    {
        $id = $model->id;
        $item = $this->getLevelById($id);

        if($item){

            $item->name = $model->name;
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }

    public function deleteLevel(int $id): bool
    {
        $item = $this->getLevelById($id);
        return  $item && $item->delete();
    }

    public function importLevels($file_path): int
    {

        $import = new ImportLevels;
        $import->import($file_path);
        return $import->getRowCount();

    }

    public function getLevels(): Collection
    {
        return Level::all();

    }


}
