<?php
namespace Modules\Users\Infrastructure\User;

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

    public function editUser($model): EndUser|null
    {
        $item = $this->getUserByID($model->id);

        if($item){

            $item->name = $model->name;
            $item->email = $model->email;

            if(filled($model->password)){
                $item->password = bcrypt($model->password);
            }

            $item->is_active = $model->isActive;
            $item->updated_by = $model->updatedBy;
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }

    public function deleteUser(int $id, int $deletedBy): bool
    {
        $item = $this->getUserById($id);
        $item->deleted_at = now();
        $item->deleted_by = $deletedBy;

        return  $item && $item->save();

    }

    public function importUsers($file_path): int
    {
        $import = new ImportUsers;
        $import->import($file_path);

        return $import->getRowCount();

    }

    public function createUser(string $name, string $email, string $password, int $organizationId, int $createdBy, int $isActive): EndUser
    {
        $item = new EndUser();
        $item->name = $name;
        $item->email = $email;
        $item->password = bcrypt($password);

        $item->type = EnumUserTypes::User;
        $item->created_by = $createdBy;
        $item->Organization_id = $organizationId;
        $item->is_active = $isActive;
        $item->save();

        return $item;
    }
}
