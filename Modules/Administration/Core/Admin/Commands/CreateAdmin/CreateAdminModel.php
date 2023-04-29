<?php

namespace Modules\Administration\Core\Admin\Commands\CreateAdmin;
use App\Enums\EnumUserTypes;
use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Create Admin Request Model",
 *     description="Create Admin request",
 *     required={"name", "email", "password", "roleId", "isActive"},
 *     @OA\Xml(
 *         name="CreateAdminModel"
 *     ),
 *     @OA\Property(
 *        property="name",
 *        type="string",
 *        description="Admin Name"
 *    ),
 *    @OA\Property(
 *        property="email",
 *        type="string",
 *        description="Admin Email"
 *    ),
 *   @OA\Property(
 *        property="password",
 *        type="string",
 *        description="Admin password"
 *    ),
 *    @OA\Property(
 *        property="roleId",
 *        type="integer",
 *        description="admin role id"
 *    ),
 *    @OA\Property(
 *        property="isActive",
 *        type="integer",
 *        description="admin status : 1->active, 0->notactive"
 *    ),
 * )
 */
class CreateAdminModel extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public int $type,
        public int $roleId,
        public int $createdBy,
        public int $isActive,
    ) {
    }
}
