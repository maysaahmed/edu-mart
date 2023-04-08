<?php

namespace App\Service\User;

use App\Core\User\Commands\CreateUser\CreateUserModel;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateUserRequest
 * @package App\Service\User
 * @OA\Schema(
 *     schema="CreateUserRequest",
 *     type="object",
 *     title="CreateUserRequest",
 *     required={"name", "emai", "password"},
 *     properties={
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="email", type="string"),
 *         @OA\Property(property="password", type="string")
 *     }
 * )
 * @OA\Schema(
 *     schema="CreateUserRequestValidationError",
 *     type="object",
 *     title="CreateUserRequestValidationError",
 *     properties={
 *         @OA\Property(property="message", type="string", default="The given data was invalid."),
 *         @OA\Property(property="errors", type="object", properties={
 *             @OA\Property(property="name", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="email", type="array", @OA\Items(type="string")),
 *             @OA\Property(property="passowrd", type="array", @OA\Items(type="string")),
 *         }),
 *         @OA\Property(property="status_code", type="integer", default="422"),
 *     }
 * )
 */
class CreateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ];
    }

    public function data(): CreateUserModel
    {
        $model = new CreateUserModel();
        $model->name = $this->input('name');
        $model->email = $this->input('email');
        $model->password = $this->input('password');
        return $model;
    }
}
