<?php
namespace Modules\Courses\Core\Request\Queries\GetApprovedRequestsCount;


interface IGetApprovedRequestsCount
{
    public function execute(): int;
}
