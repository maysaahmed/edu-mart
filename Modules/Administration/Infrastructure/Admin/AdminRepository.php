<?php
namespace Modules\Administration\Infrastructure\Admin;

use Modules\Administration\Core\Admin\Commands\CreateAdmin\CreateAdminModel;
use Modules\Administration\Core\Admin\Queries\GetAdminPagination\GetAdminPaginationModel;
use Modules\Administration\Core\Admin\Repositories\IAdminRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Administration\Domain\Entities\Admin\Admin;

class AdminRepository extends Repository implements IAdminRepository
{
    protected function model(): string
    {
        return Admin::class;
    }

    public function getAdminByEmail(string $email): Admin|null
    {
        return $admin = Admin::Where('email', $email)->first();
    }

    public function getAdminsPagination(GetAdminPaginationModel $model): LengthAwarePaginator
    {
        if ($model->name) {
            $this->addCriteria(new NameCriteria($model->name));
        }

        $this->addCriteria(new OrderByLatest());
        return $this->paginator(50, $model->page);
    }

    public function createAdmin(CreateAdminModel $model): Admin
    {
        $admin = new Admin();
        $admin->name = $model->name;
        $admin->email = $model->email;
        $admin->password = bcrypt($model->password);
        $admin->save();

        return $admin;
    }
}
