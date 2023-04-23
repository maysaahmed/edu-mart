<?php
namespace Modules\Courses\Core\Level\Commands\ImportLevel;

use Modules\Courses\Core\Level\Repositories\ILevelRepository;

class ImportLevel implements IImportLevel
{
    private ILevelRepository $repository;

    public function __construct(ILevelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $file_path): int
    {
        $rowUploaded =  $this->repository->importLevels($file_path);
        if($rowUploaded)
            return $rowUploaded;

        throw new \Exception('Levels failed to uploaded!');
    }
}
