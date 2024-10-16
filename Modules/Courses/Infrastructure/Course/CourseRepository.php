<?php
namespace Modules\Courses\Infrastructure\Course;

use Illuminate\Support\Collection;
use Modules\Courses\Core\Course\Commands\CreateCourse\CreateCourseModel;
use Modules\Courses\Core\Course\Commands\EditCourse\EditCourseModel;
use Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination\GetOrganizationCoursesPaginationModel;
use Modules\Courses\Core\Course\Queries\GetUserCoursesPagination\GetUserCoursesPaginationModel;
use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Courses\Domain\Entities\Course;

use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
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

    public function getMinMaxCoursePrice($org_id): array|null
    {
        return Course::select(\DB::raw("MIN(price) AS priceFrom, MAX(price) AS priceTo"))
            ->whereDoesntHave('organizations', function (Builder $q) use( $org_id) {
                $q->where('id', $org_id);
            })->get()->toArray();
    }

    public function getCourses(): Collection
    {
        return  Course::latest()
            ->get();
    }
    public function getArchivedCourses(): \Illuminate\Support\Collection
    {
        return  Course::onlyTrashed()
            ->latest()
            ->get();
    }
    public function getOrganizationCoursesPagination(GetOrganizationCoursesPaginationModel $model): LengthAwarePaginator
    {
        $query = QueryBuilder::for(Course::class);

        if(isset($model->visibility) and $model->visibility){
            $query = $query->whereDoesntHave('organizations', function (Builder $q) {
                $q->where('id', request()->user()->organization_id);
            });
        }
        if(isset($model->visibility) and $model->visibility == false){

            $query = $query->whereHas('organizations', function (Builder $q) {
                $q->where('id', request()->user()->organization_id);
            });
        }
        return $query->allowedFilters('title', 'duration', 'price', 'level_id', 'provider_id')
            ->latest()
            ->paginate();

    }

    public function getUserCoursesPagination(GetUserCoursesPaginationModel $model): LengthAwarePaginator
    {
        $org_id = $model->organization_id;

        $query = QueryBuilder::for(Course::class)
                ->allowedIncludes('requests')
                ->whereDoesntHave('organizations', function (Builder $q) use( $org_id) {

                    $q->where('id', $org_id);
                });
        if(isset($model->status) and $model->status != 'all')
        {
            $status = match ($model->status) {
                "pending" => 0,
                "approved" => 1,
                "rejected" => 2,
                "canceled" => 3,
                "booked" => 4
            };

            $query = $query->whereHas('requests', function (Builder $q) use ($status){
                $q->latest()->limit(1)->where(['user_id' => request()->user()->id, 'status' => $status]);
            });
        }

        if(isset($model->price_min))
        {
            $query = $query->where('price' , '>=' , $model->price_min);
        }

        if(isset($model->price_max))
        {
            $query = $query->where('price' , '<=' , $model->price_max);
        }


        return $query->allowedFilters('title', 'location', 'level_id', 'provider_id', 'category_id')
            ->allowedSorts(['title', 'price'])
            ->latest()
            ->paginate(9);

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

    public function editCourseVisibility($course_id, $org_id): bool|null
    {

        $course = $this->getCourseById($course_id);

        if($course){
            if($course->organizations->contains($org_id))
                $course->organizations()->detach($org_id);
            else
                $course->organizations()->attach([$org_id]);
            return true;
        }

        return null;
    }

    public function checkCourseVisibility($course_id, $org_id): bool|null
    {

        $course = $this->getCourseById($course_id);

        if($course){
            if($course->organizations->contains($org_id))
                return false;
        }

        return true;
    }


}
