<?php

namespace App\Core\User\Queries\GetUserPagination;

class GetUserPaginationModel
{
    public int $page = 1;
    public ?string $name;

    public function __construct(int $page, ?string $name = null)
    {
        $this->page = $page;
        $this->name = $name;
    }

}
