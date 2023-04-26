<?php


namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\SecurityScheme(
 *     type="https",
 *     description="Login with email and password to get the authentication token",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth",
 * )
 */

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Edu Mart API",
 *      description="Edu Mart API Documentation",
 *      @OA\Contact(
 *          email="admin@@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

}
