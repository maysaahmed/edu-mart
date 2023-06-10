<?php

namespace Modules\Administration\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class RolePermissionResourceCollection extends ResourceCollection
{

    protected string $role;

    public function role($value)
    {
        $this->role = $value;
        return $this;
    }


    public function toArray($request)
    {
        return $this->collection->map(function (RolePermissionResource $resource) use ($request) {
            return $resource->role($this->role)->toArray($request);
        })->all();
    }
}
