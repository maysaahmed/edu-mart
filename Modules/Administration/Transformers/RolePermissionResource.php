<?php

namespace Modules\Administration\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use JetBrains\PhpStorm\Pure;
use Ramsey\Uuid\Type\Integer;
use Spatie\Permission\Models\Role;

class RolePermissionResource extends JsonResource
{

    protected string $role;

    public function role($value)
    {
        $this->role = (int)$value;
        return $this;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $permission = $this->name;
        $role = Role::find($this->role);

        return [
            'id' => $this->id,
            'name' => $permission,
            'title' => ucwords(str_replace("_", " ", $permission)),
            'roleInclude' =>  isset($role) && $role->hasPermissionTo($permission)
        ];
    }

    public static function collection($resource){
        return new PermissionResourceCollection($resource);
    }
}
