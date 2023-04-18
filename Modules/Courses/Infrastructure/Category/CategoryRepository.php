<?php
namespace Modules\Courses\Infrastructure\Category;

use Modules\Courses\Core\Category\Commands\EditCategory\EditCategoryModel;
use Modules\Courses\Core\Category\Queries\GetCategoryPagination\GetCategoryPaginationModel;
use Modules\Courses\Core\Category\Repositories\ICategoryRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Category;
use Spatie\QueryBuilder\QueryBuilder;
use Modules\Courses\Infrastructure\Category\Imports\ImportCategories;

class CategoryRepository extends Repository implements ICategoryRepository
{
    protected function model(): string
    {
        return Category::class;
    }

    public function getCategoryById($id): Category
    {
        return Category::find($id);
    }

    public function getCategoriesPagination(GetCategoryPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Category::class)
            ->allowedFilters('name')
            ->paginate();
    }

    public function createCategory(string $name): Category
    {
        $cat = new Category();
        $cat->name = $name;
        $cat->save();

        return $cat;
    }

    public function editCategory(EditCategoryModel $model): Category|null
    {
        $id = $model->id;
        $item = $this->getCategoryById($id);

        if($item){

            $item->name = $model->name;
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }

    public function deleteCategory(int $id): bool
    {
        $item = $this->getCategoryById($id);
        return  $item && $item->delete();
    }

    public function importCategories($file_path): int
    {

        $import = new ImportCategories;
        $import->import($file_path);
        return $import->getRowCount();

    }


}
