<?php
namespace Modules\Organizations\Core\Organization\Queries\GetOrganizationPagination;

class GetOrganizationPaginationModel
{
    public int $page = 1;
    public ?string $name;

    public function __construct(int $page, ?string $name = null, ?string $phone = null, ?string $address = null)
    {
        $this->page = $page;
        $this->name = $name;
        $this->phone = $phone;
        $this->address = $address;
    }

}
