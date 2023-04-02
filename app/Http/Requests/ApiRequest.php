<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Traits\ApiResponser;

class ApiRequest extends FormRequest
{
    use ApiResponser;
}
