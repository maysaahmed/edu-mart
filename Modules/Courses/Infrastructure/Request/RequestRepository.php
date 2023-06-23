<?php
namespace Modules\Courses\Infrastructure\Request;

use Modules\Courses\Core\Request\Commands\CreateRequest\CreateRequestModel;
use Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination\GetOrganizationRequestsPaginationModel;
use Modules\Courses\Core\Request\Repositories\IRequestRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Request;
use Spatie\QueryBuilder\QueryBuilder;
use DB;

class RequestRepository extends Repository implements IRequestRepository
{
    protected function model(): string
    {
        return Request::class;
    }

    public function getRequestById($id): Request|null
    {
        return Request::find($id);
    }

    public function getOrganizationRequestsPagination(GetOrganizationRequestsPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Request::class)
            ->allowedIncludes('user')
            ->select('course_requests.*', DB::raw('users.organization_id as organization_id'), DB::raw('users.name as user_name') )
            ->join('users', 'course_requests.user_id', '=', 'users.id')
            ->where('organization_id', $model->org_id)
            ->allowedFilters('user.name')
            ->latest()
            ->paginate();
    }

    public function getOrganizationRequestsCount(int $org_id): int
    {
        return Request::leftjoin('users', 'course_requests.user_id', '=', 'users.id')
            ->where('users.organization_id', $org_id)->where('status', 0)->count();
    }


    public function createRequest(CreateRequestModel $model): Request
    {
        $request = new Request();
        $request->user_id = $model->user_id;
        $request->course_id = $model->course_id;
        $request->status = 0;
        $request->save();
        return $request;
    }


    public function editRequestStatus($id, $status): bool|null
    {

        $item = $this->getRequestById($id);

        if($item){
            $item->update(['status' => (int) $status]);
            return true;
        }

        return null;
    }


}
