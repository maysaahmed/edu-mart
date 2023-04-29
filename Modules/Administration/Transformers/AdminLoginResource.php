<?php

namespace Modules\Administration\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AdminLoginResource extends JsonResource
{
    protected string $token;

    public function token($value)
    {
        $this->token = $value;
        return $this;
    }

    public function toArray($request)
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'token' => $this->token,
            'role' => $this->getRoleNames()->first() ?? '',
            'permissions' => PermissionResource::collection($this->getAllPermissions()),
        ];
    }
}
