<?php
namespace Modules\Courses\Infrastructure\Course;

use Illuminate\Support\Collection;
use Modules\Assessment\Domain\Entities\Result;
use Modules\Courses\Domain\Entities\CourseFactor;
use Modules\Courses\Core\Course\Commands\CreateCourse\CreateCourseModel;
use Modules\Courses\Core\Course\Commands\EditCourse\EditCourseModel;
use Modules\Courses\Core\Course\Queries\GetOrganizationCoursesPagination\GetOrganizationCoursesPaginationModel;
use Modules\Courses\Core\Course\Queries\GetUserCourses\GetUserCoursesModel;
use Modules\Courses\Core\Course\Queries\GetCourses\GetCoursesModel;
use Modules\Courses\Core\Course\Queries\GetArchivedCourses\GetArchivedCoursesModel;
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

    public function getCourses(GetCoursesModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Course::class)
            ->allowedFilters('title', 'duration', 'price')
            ->latest()
            ->paginate();
    }
    public function getArchivedCourses(GetArchivedCoursesModel $model): LengthAwarePaginator
    {
        return  QueryBuilder::for(Course::class)
            ->allowedFilters('title')
            ->onlyTrashed()
            ->latest()
            ->paginate();
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

    public function getUserCourses(GetUserCoursesModel $model): \Illuminate\Database\Eloquent\Collection
    {
        $org_id = $model->organization_id;

        $query = QueryBuilder::for(Course::class)
                ->allowedIncludes('requests');
        if($org_id){
            $query->whereDoesntHave('organizations', function (Builder $q) use( $org_id) {
                $q->where('id', $org_id);
            });
        }

        if(isset($model->status) and $model->status != 'all')
        {
            $status = match ($model->status) {
                "pending" => 0,
                "approved" => 1,
                "rejected" => 2,
                "canceled" => 3,
                "booked" => 4
            };
            if($model->status == 'approved' || $model->status == 'booked')
            {
                $query = $query->whereHas('requests', function (Builder $q) {
                    $q->latest()->limit(1)->whereIn('status', [1, 4])->where('user_id', request()->user()->id);
                });
            }elseif ($model->status == 'rejected' || $model->status == 'canceled') {
                $query = $query->whereHas('requests', function (Builder $q) {
                    $q->latest()->limit(1)->whereIn('status', [2, 3])->where('user_id', request()->user()->id);
                });
            }else{
                $query = $query->whereHas('requests', function (Builder $q) use ($status){
                    $q->latest()->limit(1)->where(['user_id' => request()->user()->id, 'status' => $status]);
                });
            }
        }

        return $query->latest()->get();

    }


    public function getRecommendedCourses(int $user_id): \Illuminate\Database\Eloquent\Collection
    {
        $userFactors = Result::where('user_id', $user_id)->get();
        return Course::whereHas('courseFactors', function ($query) use ($userFactors) {
            $query->where(function ($query) use ($userFactors) {
                foreach ($userFactors as $factor) {
                    $query->orWhere(function ($query) use ($factor) {
                        if ($factor->result <= 24) {
                            $query->where('factor_id', $factor->factor_id)
                                ->whereRaw('FIND_IN_SET(?, result)', ['low']);
                        } elseif ($factor->result >= 25 && $factor->result <=35) {
                            $query->where('factor_id', $factor->factor_id)
                                ->whereRaw('FIND_IN_SET(?, result)', ['moderate']);
                        } elseif ($factor->result > 35) {
                            $query->where('factor_id', $factor->factor_id)
                                ->whereRaw('FIND_IN_SET(?, result)', ['high']);
                        }

                    });
                }
            });
        })->distinct()->get();

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

        foreach($model->factors as $item)
        {
            CourseFactor::create([
                'course_id' => $course->id,
                'factor_id' => $item['factor'],
                'result'    => implode(', ', $item['result'])
            ]);
        }
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

                foreach($model->factors as $item)
                {
                    $course->courseFactors()->updateOrCreate(
                        ['factor_id' => $item['factor']],
                        ['result' => implode(', ', $item['result'])]
                    );

                }
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
