<?php

namespace Modules\Administration\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="Permission Resource",
 *     description="Permission resource",
 *     @OA\Xml(
 *         name="PermissionResource"
 *     ),
 *   @OA\Property(
 *        property="name",
 *        type="string",
 *        description="permission name",
 *        nullable=false,
 *        format="edit_admin"
 *    ),
 *    @OA\Property(
 *        property="title",
 *        type="string",
 *        description="permission title",
 *        nullable=false,
 *        format="edit admin"
 *    ),
 * )
 */
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
            'id' => $this->id,
            'name' => $permission,
            'title' => ucwords(str_replace("_", " ", $this->name))
        ];
    }
}
