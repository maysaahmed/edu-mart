<?php

namespace Modules\Administration\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="Admin Login Resource",
 *     description="Admin login resource",
 *     @OA\Xml(
 *         name="AdminLoginResource"
 *     ),
 *   @OA\Property(
 *        property="name",
 *        type="string",
 *        description="Admin Name",
 *        nullable=false,
 *        format="edumart admin"
 *    ),
 *    @OA\Property(
 *        property="email",
 *        type="string",
 *        description="Admin Email",
 *        nullable=false,
 *        format="admin@admin.com"
 *    ),
 *    @OA\Property(
 *        property="token",
 *        type="string",
 *        description="Admin auth token",
 *        nullable=false,
 *        format="1uhjkjg675"
 *    ),
 *    @OA\Property(
 *        property="role",
 *        type="string",
 *        description="Admin role",
 *        nullable=false,
 *        format="Editor"
 *    ),
 *    @OA\Property(
 *        property="permissions",
 *        type="array",
 *        @OA\Items(
 *               type="string",
 *               description="the permission details",
 *               @OA\Schema(ref="#/components/schemas/PermissionResource")
 *         ),
 *        description="Admin permissions",
 *        nullable=false,
 *        format="[]"
 *    ),
 * )
 */

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
