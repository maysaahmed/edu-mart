<?php
namespace Modules\Users\Core\Manager\Commands\ImportManager;

use Modules\Users\Core\Manager\Repositories\IManagerRepository;

class ImportManager implements IImportManager
{
    private IManagerRepository $repository;

    public function __construct(IManagerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $file_path): int
    {
        $rowUploaded =  $this->repository->importManagers($file_path);
        if($rowUploaded)
            return $rowUploaded;

        throw new \Exception('Manager failed to upload!');
    }
}
