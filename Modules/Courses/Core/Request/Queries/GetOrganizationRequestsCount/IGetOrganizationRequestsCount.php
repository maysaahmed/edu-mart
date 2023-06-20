<?php
namespace Modules\Courses\Core\Request\Queries\GetOrganizationRequestsCount;


interface IGetOrganizationRequestsCount
{
    public function execute(int $org_id): int;
}
