<?php

namespace App\Http\Controllers\User;

use App\Core\User\Queries\GetUserPagination\GetUserPaginationModel;
use App\Http\Requests\ApiRequest;

class GetUserPaginationRequest extends ApiRequest
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
