<?php

namespace Modules\Administration\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     title="Admin Resource",
 *     description="Admin resource",
 *     @OA\Xml(
 *         name="AdminResource"
 *     ),
 *    @OA\Property(
 *        property="id",
 *        type="integer",
 *        description="Admin ID",
 *        nullable=false,
 *        example="1"
 *    ),
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
 *        property="status",
 *        type="integer",
 *        description="Admin status : 1->active, 0->notactive",
 *        nullable=false,
 *        format="1"
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

class AdminResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => $this->is_active,
            'role' => $this->getRoleNames()->first() ?? '',
            'permissions' => PermissionResource::collection($this->getAllPermissions())
        ];
    }
}
