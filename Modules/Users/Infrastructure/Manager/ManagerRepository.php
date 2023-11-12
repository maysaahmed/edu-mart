<?php
namespace Modules\Users\Infrastructure\Manager;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Core\Manager\Commands\EditManager\EditManagerModel;
use Modules\Users\Core\Manager\Commands\CreateManager\CreateManagerModel;
use Modules\Users\Core\Manager\Commands\EditManagerStatus\EditManagerStatusModel;
use Modules\Users\Core\Manager\Repositories\IManagerRepository;
use App\Infrastructure\Repository\Repository;
use Modules\Users\Core\Manager\Queries\GetManagerPagination\GetManagerPaginationModel;
use Modules\Users\Domain\Entities\Manager;
use App\Enums\EnumUserTypes;
use Illuminate\Database\Eloquent\Collection;
use Modules\Users\Domain\Entities\VerifyUser;
use Spatie\QueryBuilder\QueryBuilder;
use DB;
use Modules\Users\Infrastructure\Manager\Imports\ImportManagers;

class ManagerRepository extends Repository implements IManagerRepository
{
    protected function model(): string
    {
        return Manager::class;
    }

    public function getManagerById($id): Manager|null
    {
        return Manager::where(['id'=>$id, 'type' => EnumUserTypes::Manager->value])->first();
    }

    public function getOrganizationManagers($org_id): Collection
    {
        return Manager::where(['organization_id' => $org_id, 'type' => EnumUserTypes::Manager->value])->select('id','name')->get();
    }

    public function getManagersPagination(GetManagerPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Manager::class)
            ->allowedIncludes('organization')
            ->select('users.*',  DB::raw('organizations.name as organization_name') )
            ->join('organizations', 'users.organization_id', '=', 'organizations.id')
            ->where('type', EnumUserTypes::Manager)
            ->allowedFilters('name', 'email', 'organization.name')
            ->latest()
            ->paginate();
    }


    public function editManager(EditManagerModel $model): Manager|null
    {
        $item = $this->getManagerByID($model->id);
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

    public function deleteManager(int $id, int $deletedBy): bool
    {
        $item = $this->getManagerById($id);
        $item->deleted_at = now();
        $item->deleted_by = $deletedBy;

        return  $item && $item->save();
    }

    public function editManagerStatus(EditManagerStatusModel $model): Manager|null
    {
        $id = $model->id;
        $item = $this->getManagerById($id);

        if($item){

            $item->is_active = $model->isActive;
            $save = $item->save();

            if ($save) {
                return $item;
            }
        }

        return null;
    }

    public function createManager(CreateManagerModel $model): Manager
    {
        $user = new Manager();
        $user->name = $model->name;
        $user->email = $model->email;
        $user->password = bcrypt($model->password);
        $user->created_by = $model->createdBy;
        $user->organization_id = $model->organization_id;
        $user->check_email_status = 0;  // 1 for verified
        $user->type =$model->type;
        $user->is_active = 1;
        $user->save();

        VerifyUser::create([
            'user_id' => $user->id,
            'token' => sha1(time())
        ]);

        return $user;
    }

    public function importManagers($file_path): int|null
    {
        $import = new ImportManagers;
        $import->import($file_path);

        return $import->getRowCount();

    }
}
