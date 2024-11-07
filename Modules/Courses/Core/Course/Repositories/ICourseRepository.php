<?php
namespace Modules\Courses\Core\Course\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Support\Collection;
use Modules\Courses\Core\Course\Commands\CreateCourse\CreateCourseModel;
use Modules\Courses\Core\Course\Commands\EditCourse\EditCourseModel;
use Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination\GetOrganizationCoursesPaginationModel;
use Modules\Courses\Core\Course\Queries\GetUserCourses\GetUserCoursesModel;
use Modules\Courses\Core\Course\Queries\GetCourses\GetCoursesModel;
use Modules\Courses\Core\Course\Queries\GetArchivedCourses\GetArchivedCoursesModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Course;

interface ICourseRepository extends IRepository
{
    public function getCourseById($id): Course|null;
    public function getCourses(GetCoursesModel $model): LengthAwarePaginator;
    public function getArchivedCourses(GetArchivedCoursesModel $model): LengthAwarePaginator;
    public function getOrganizationCoursesPagination(GetOrganizationCoursesPaginationModel $model): LengthAwarePaginator;
    public function getUserCourses(GetUserCoursesModel $model): \Illuminate\Database\Eloquent\Collection;
    public function createCourse(CreateCourseModel $model): Course;
    public function editCourse(EditCourseModel $model): Course|null;
    public function deleteCourse(int $id): bool;
    public function importCourses(string $file_path): int;
    public function editCourseVisibility(int $course_id, int $org_id): bool|null;
    public function checkCourseVisibility(int $course_id, int $org_id): bool|null;
    public function getMinMaxCoursePrice(int $org_id): array|null;
}
