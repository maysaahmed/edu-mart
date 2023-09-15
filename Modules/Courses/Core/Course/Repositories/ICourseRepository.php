<?php
namespace Modules\Courses\Core\Course\Repositories;

use App\Core\Repository\IRepository;
use Modules\Courses\Core\Course\Commands\CreateCourse\CreateCourseModel;
use Modules\Courses\Core\Course\Commands\EditCourse\EditCourseModel;
use Modules\Courses\Core\Course\Queries\GetCoursePagination\GetCoursePaginationModel;
use Modules\Courses\Core\Course\Queries\GetArchivedCoursePagination\GetArchivedCoursePaginationModel;
use Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination\GetOrganizationCoursesPaginationModel;
use Modules\Courses\Core\Course\Queries\GetUserCoursesPagination\GetUserCoursesPaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Course;

interface ICourseRepository extends IRepository
{
    public function getCourseById($id): Course|null;
    public function getCoursesPagination(GetCoursePaginationModel $model): LengthAwarePaginator;
    public function getArchivedCoursesPagination(GetArchivedCoursePaginationModel $model): LengthAwarePaginator;
    public function getOrganizationCoursesPagination(GetOrganizationCoursesPaginationModel $model): LengthAwarePaginator;
    public function getUserCoursesPagination(GetUserCoursesPaginationModel $model): LengthAwarePaginator;
    public function createCourse(CreateCourseModel $model): Course;
    public function editCourse(EditCourseModel $model): Course|null;
    public function deleteCourse(int $id): bool;
    public function importCourses(string $file_path): int;
    public function editCourseVisibility(int $course_id, int $org_id): bool|null;
    public function checkCourseVisibility(int $course_id, int $org_id): bool|null;
}
