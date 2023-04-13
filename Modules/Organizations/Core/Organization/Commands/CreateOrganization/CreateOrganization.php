<?php
namespace Modules\Organizations\Core\Organization\Commands\CreateOrganization;

use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class CreateOrganization implements ICreateOrganization
{
    private IOrganizationRepository $repository;

    public function __construct(IOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateOrganizationModel $model): Organization
    {
        return $this->repository->createOrganization($model);
    }
}
