<?php
namespace Modules\Users\Infrastructure\Manager;

use Modules\Users\Core\Manager\Repositories\IManagerRepository;
use App\Infrastructure\Repository\Repository;
use Modules\Users\Domain\Entities\Manager;
use App\Enums\EnumUserTypes;

class ManagerRepository extends Repository implements IManagerRepository
{
    protected function model(): string
    {
        return Manager::class;
    }

    public function getManagerById($id): Manager|null
    {
        return Manager::find($id);
    }



}
