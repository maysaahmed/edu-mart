<?php
namespace Modules\Courses\Core\Course\Commands\ImportCourse;

use Modules\Courses\Core\Course\Repositories\ICourseRepository;

class ImportCourse implements IImportCourse
{
    private ICourseRepository $repository;

    public function __construct(ICourseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $file_path): int
    {
       $rowUploaded =  $this->repository->importCourses($file_path);
       if($rowUploaded)
           return $rowUploaded;

       throw new \Exception('Course failed to upload!');
    }
}
