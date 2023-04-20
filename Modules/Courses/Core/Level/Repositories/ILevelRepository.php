<?php
namespace Modules\Courses\Core\Level\Repositories;

use App\Core\Repository\IRepository;
use Modules\Courses\Core\Level\Queries\GetLevelPagination\GetLevelPaginationModel;
use Modules\Courses\Core\Level\Commands\EditLevel\EditLevelModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Level;
use Illuminate\Support\Collection;

interface ILevelRepository extends IRepository
{
    public function getLevelById($id): Level|null;
    public function getLevelsPagination(GetLevelPaginationModel $model): LengthAwarePaginator;
    public function createLevel(string $name): Level;
    public function editLevel(EditLevelModel $model): Level|null;
    public function deleteLevel(int $id): bool;
    public function importLevels(string $file_path): int;
    public function getLevels(): Collection;
}
