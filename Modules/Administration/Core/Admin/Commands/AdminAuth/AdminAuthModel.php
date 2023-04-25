<?php

namespace Modules\Administration\Core\Admin\Commands\AdminAuth;
use OpenApi\Annotations as OA;
use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="AdminAuthRequestModel",
 *     description="Admin Auth request",
 *     required={"email", "password"},
 *     @OA\Xml(
 *         name="AdminAuthModel"
 *     ),
 *    @OA\Property(
 *        property="email",
 *        type="string",
 *        description="Admin Email"
 *    ),
 *   @OA\Property(
 *        property="password",
 *        type="passowrd",
 *        description="Admin password"
 *    ),
 * )
 */

class AdminAuthModel extends Data
{
     public function __construct(
        public string $email,
        public string $password,
    ) {
    }

}
