<?php
namespace Modules\Administration\Infrastructure\Permission;

use App\Core\Repository\ICriteria;
use Illuminate\Database\Eloquent\Builder;

class RoleIdCriteria implements ICriteria
{
    private string $role_id;

    public function __construct(int $id)
    {
        $this->role_id = $id;
    }

    public function apply(Builder $query): Builder
    {
        $role_id = $this->role_id;
        $query->whereHas('roles', function ($q) use ($role_id) {
            $q->where('role_id', $role_id);
        });
        return $query;
    }
}
