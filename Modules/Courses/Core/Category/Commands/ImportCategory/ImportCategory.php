<?php
namespace Modules\Courses\Core\Category\Commands\ImportCategory;

use Modules\Courses\Core\Category\Repositories\ICategoryRepository;

class ImportCategory implements IImportCategory
{
    private ICategoryRepository $repository;

    public function __construct(ICategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $file_path): int
    {
        $rowUploaded =  $this->repository->importCategories($file_path);
        if($rowUploaded)
            return $rowUploaded;

        throw new \Exception('Categories failed to uploaded!');
    }
}
