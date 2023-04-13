<?php
namespace Modules\Administration\Core\Admin\Queries\GetAdminPagination;

class GetAdminPaginationModel
{
    public int $page = 1;
    public ?string $name;

    public function __construct(int $page, ?string $name = null)
    {
        $this->page = $page;
        $this->name = $name;
    }

}
