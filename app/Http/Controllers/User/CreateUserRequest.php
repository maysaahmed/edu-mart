<?php

namespace App\Http\Controllers\User;

use App\Core\User\Commands\CreateUser\CreateUserModel;
use App\Http\Requests\ApiRequest;

class CreateUserRequest extends ApiRequest
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
