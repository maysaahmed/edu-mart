<?php

namespace Modules\Administration\Core\Admin\Commands\EditAdmin;
use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Edit Admin Request Model",
 *     description="Edit Admin request",
 *     required={"name", "email", "roleId", "isActive", "_method"},
 *     @OA\Xml(
 *         name="EditAdminModel"
 *     ),
 *    @OA\Property(
 *        property="email",
 *        type="string",
 *        description="Admin Email"
 *    ),
 *   @OA\Property(
 *        property="name",
 *        type="string",
 *        description="Admin Name"
 *    ),
 *    @OA\Property(
 *        property="roleId",
 *        type="integer",
 *        description="Role Id"
 *    ),
 *    @OA\Property(
 *        property="isActive",
 *        type="integer",
 *        description="Admin Status"
 *    ),
 *    @OA\Property(
 *        property="_method",
 *        type="string",
 *        description="put method for update"
 *    ),
 * )
 */

class EditAdminModel extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public int $roleId,
        public int $isActive,
        public int $updatedBy,
        public ?string $password = null,
    ) {
    }

}
