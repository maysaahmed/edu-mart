<?php
namespace Modules\Users\Infrastructure\User;

use Modules\Courses\Domain\Entities\Request;
use Modules\Users\Core\User\Commands\CreateUser\CreateUserModel;
use Modules\Users\Core\User\Commands\EditUser\EditUserModel;
use Modules\Users\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use Modules\Users\Core\User\Repositories\IUserRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Domain\Entities\EndUser;
use App\Enums\EnumUserTypes;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Modules\Users\Infrastructure\User\Imports\ImportUsers;

class UserRepository extends Repository implements IUserRepository
{
    protected function model(): string
    {
        return EndUser::class;
    }

    public function getUserById($id): EndUser|null
    {
        return EndUser::find($id);
    }

    public function getUsersPagination(GetUserPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(EndUser::class)
            ->where('organization_id', $model->org_id)
            ->where('type', EnumUserTypes::User)
            ->allowedFilters('name', 'email', 'created_by')
            ->paginate();
    }


    public function deleteUser(int $id): bool
    {
        $item = $this->getUserById($id);
        return  $item && $item->delete();
    }

    public function importUsers($file_path): int
    {
        $import = new ImportUsers;
        $import->import($file_path);

        return $import->getRowCount();

    }

}
