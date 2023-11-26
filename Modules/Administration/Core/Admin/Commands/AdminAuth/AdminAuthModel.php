<?php

namespace Modules\Administration\Core\Admin\Commands\AdminAuth;
use OpenApi\Annotations as OA;
use phpDocumentor\Reflection\Types\Boolean;
use Spatie\LaravelData\Data;

/**
 * @OA\Schema(
 *     title="Admin Auth Request Model",
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
 *        type="string",
 *        description="Admin password"
 *    ),
 * )
 */

class AdminAuthModel extends Data
{
     public function __construct(
        public string $email,
        public string $password,
        public bool $rememberMe
    ) {
    }

}
