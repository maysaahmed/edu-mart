<?php

namespace App\Http\User;

use App\Core\User\Commands\CreateUser\CreateUserModel;
use Illuminate\Foundation\Http\FormRequest;

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
