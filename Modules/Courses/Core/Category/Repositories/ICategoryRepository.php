<?php
namespace Modules\Courses\Core\Category\Repositories;

use App\Core\Repository\IRepository;
use Modules\Courses\Core\Category\Queries\GetCategoryPagination\GetCategoryPaginationModel;
use Modules\Courses\Core\Category\Commands\EditCategory\EditCategoryModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Category;
use Illuminate\Support\Collection;

interface ICategoryRepository extends IRepository
{
    public function getCategoryById($id): Category|null;
    public function getCategoriesPagination(GetCategoryPaginationModel $model): LengthAwarePaginator;
    public function createCategory(string $name): Category;
    public function editCategory(EditCategoryModel $model): Category|null;
    public function deleteCategory(int $id): bool;
    public function importCategories(string $file_path): int;
    public function getCategories(): Collection;
}
