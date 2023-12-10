<?php
namespace Modules\Courses\Core\Request\Repositories;

use App\Core\Repository\IRepository;
use Modules\Courses\Core\Request\Commands\CreateRequest\CreateRequestModel;
use Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination\GetOrganizationRequestsPaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Request;

interface IRequestRepository extends IRepository
{
    public function getRequestById($id): Request|null;
    public function getRequestByCourseId($user_id, $course_id): Request|null;
    public function getOrganizationRequestsPagination(GetOrganizationRequestsPaginationModel $model): LengthAwarePaginator;
    public function getApprovedRequestsPagination(GetApprovedRequestsPaginationModel $model): LengthAwarePaginator;
    public function getOrganizationRequestsCount(int $org_id): int;
    public function createRequest(CreateRequestModel $model): Request;
    public function editRequestStatus(int $id, int $status): bool|null;
}
