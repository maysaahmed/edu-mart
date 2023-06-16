<?php
namespace Modules\Users\Core\Manager\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Users\Domain\Entities\Manager;

interface IManagerRepository extends IRepository
{
    public function getManagerById($id): Manager|null;
}
