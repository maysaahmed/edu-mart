<?php
namespace Modules\Courses\Core\Provider\Commands\ImportProvider;

use Modules\Courses\Core\Provider\Repositories\IProviderRepository;

class ImportProvider implements IImportProvider
{
    private IProviderRepository $repository;

    public function __construct(IProviderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $file_path): int
    {
        $rowUploaded =  $this->repository->importProviders($file_path);
        if($rowUploaded)
            return $rowUploaded;

        throw new \Exception('Providers failed to uploaded!');
    }
}
