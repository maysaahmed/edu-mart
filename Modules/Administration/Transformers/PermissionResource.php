<?php

namespace Modules\Administration\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $permission = $this->name;
        return [
            'name' => $permission,
            'title' => ucwords(str_replace("_", " ", $this->name))
        ];
    }
}
