<?php
namespace Modules\Organizations\Core\Organization\Commands\ImportOrganization;

use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;

class ImportOrganization implements IImportOrganization
{
    private IOrganizationRepository $repository;

    public function __construct(IOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $file_path): int
    {
       return $this->repository->importOrganizations($file_path);
    }
}
