<?php

namespace App\Http\User;

use App\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use Illuminate\Foundation\Http\FormRequest;

class GetUserPaginationRequest extends FormRequest
{
    public function rules(): array
    {
        return [];
    }

    public function data(): GetUserPaginationModel
    {
        return new GetUserPaginationModel(
            $this->query('page', 1),
            $this->query('name'),
        );
    }
}
