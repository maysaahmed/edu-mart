<?php
namespace Modules\Courses\Infrastructure\Request;

use Modules\Courses\Core\Request\Commands\CreateRequest\CreateRequestModel;
use Modules\Courses\Core\Request\Queries\GetOrganizationRequestsPagination\GetOrganizationRequestsPaginationModel;
use Modules\Courses\Core\Request\Queries\GetApprovedRequestsPagination\GetApprovedRequestsPaginationModel;
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


    public function getRequestByCourseId($user_id, $course_id): Request|null
    {
        return Request::where(['user_id' => $user_id, 'course_id' => $course_id])->latest()->first();
    }



    public function getOrganizationRequestsPagination(GetOrganizationRequestsPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Request::class)
            ->allowedIncludes('user')
            ->select('course_requests.*', DB::raw('users.organization_id as organization_id'), DB::raw('users.name as user_name') )
            ->join('users', 'course_requests.user_id', '=', 'users.id')
            ->where('organization_id', $model->org_id)
            ->where('users.deleted_at', NULL)
            ->allowedFilters('user.name')
            ->latest()
            ->paginate();
    }

    public function getApprovedRequestsPagination(GetApprovedRequestsPaginationModel|\Modules\Courses\Core\Request\Repositories\GetApprovedRequestsPaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Request::class)
            ->allowedIncludes('user', 'course')
            ->select('course_requests.*', DB::raw('users.name as user_name'), DB::raw('courses.title as course_title') )
            ->join('users', 'course_requests.user_id', '=', 'users.id')
            ->join('courses', 'course_requests.course_id', '=', 'courses.id')
            ->whereIn('course_requests.status', [0, 1, 3, 4])
            ->where('users.deleted_at', NULL)
            ->allowedFilters('user.name', 'course.title')
            ->latest()
            ->paginate();
//        return  QueryBuilder::for(Request::class)
//            ->allowedIncludes('user', 'course', 'organization')
//            ->select('course_requests.*', DB::raw('organizations.name as organization_name'), DB::raw('users.name as user_name'), DB::raw('courses.title as course_title') )
//            ->join('users', 'course_requests.user_id', '=', 'users.id')
//            ->join('courses', 'course_requests.course_id', '=', 'courses.id')
//            ->join('organizations', 'users.organization_id', '=', 'organizations.id')
//            ->whereIn('course_requests.status', [0, 1, 3, 4])
//            ->where('users.deleted_at', NULL)
//            ->allowedFilters('user.name', 'user.organization.name', 'course.title')
//            ->latest()
//            ->paginate();
    }

    public function getOrganizationRequestsCount(int $org_id): int
    {
        return Request::leftjoin('users', 'course_requests.user_id', '=', 'users.id')
            ->where('users.organization_id', $org_id)->where('status', 0)->count();
    }

    public function getApprovedRequestsCount(): int
    {
        return Request::where('status', 1)->count();
    }


    //change user previous rejected requests to be archived
    public function archiveRequests($user_id, $course_id)
    {
        Request::where(['user_id' => $user_id, 'course_id' => $course_id, 'status' => 2])->update(['status' => 5]);
    }
    public function createRequest(CreateRequestModel $model): Request
    {
        $this->archiveRequests($model->user_id, $model->course_id);
        $request = new Request();
        $request->user_id = $model->user_id;
        $request->course_id = $model->course_id;
        $request->status = 0;
        $request->save();
        return $request;
    }


    public function editRequestStatus($id, $status, $note = null): bool|null
    {
        $item = $this->getRequestById($id);
        if($item){

            $item->update(['status' => (int) $status, 'note' => $note]);
            return true;
        }

        return null;
    }


}
