<?php
namespace Modules\Courses\Infrastructure\Course;

use Modules\Courses\Core\Course\Commands\CreateCourse\CreateCourseModel;
use Modules\Courses\Core\Course\Commands\EditCourse\EditCourseModel;
use Modules\Courses\Core\Course\Queries\GetCoursePagination\GetCoursePaginationModel;
use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Course;
use Nwidart\Modules\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Modules\Courses\Infrastructure\Course\Imports\ImportCourses;

class CourseRepository extends Repository implements ICourseRepository
{
    protected function model(): string
    {
        return Course::class;
    }

    public function getCourseById($id): Course|null
    {
        return Course::find($id);
    }

    public function getCoursesPagination(GetCoursePaginationModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Course::class)
            ->allowedFilters('title', 'duration', 'price')
            ->paginate();
    }

    public function createCourse(CreateCourseModel $model): Course
    {
        $course = new Course();
        $course->title = $model->title;
        $course->desc = $model->desc;
        $course->duration = $model->duration;
        $course->price = $model->price;
        $course->level_id = $model->level_id;
        $course->category_id = $model->category_id;
        $course->provider_id = $model->provider_id;
        $course->location = $model->location;
        $course->save();

        return $course;
    }

    public function editCourse(EditCourseModel $model): Course|null
    {
        $id = $model->id;
        $course = $this->getCourseById($id);

        if($course){

            $course->title = $model->title;
            $course->desc = $model->desc;
            $course->duration = $model->duration;
            $course->price = $model->price;
            $course->level_id = $model->level_id;
            $course->category_id = $model->category_id;
            $course->provider_id = $model->provider_id;
            $course->location = $model->location;
            $save = $course->save();

            if ($save) {
                return $course;
            }
        }

        return null;
    }

    public function deleteCourse(int $id): bool
    {
        $item = $this->getCourseById($id);
        return  $item && $item->delete();
    }

    public function importCourses($file_path): int
    {
        $import = new ImportCourses;
        $import->import($file_path);

        return $import->getRowCount();

    }


}