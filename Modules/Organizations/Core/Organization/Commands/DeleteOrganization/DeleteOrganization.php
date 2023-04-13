<?php
namespace Modules\Organizations\Core\Organization\Commands\DeleteOrganization;

use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class DeleteOrganization implements IDeleteOrganization
{
    private IOrganizationRepository $repository;

    public function __construct(IOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        $item =$this->repository->getOrganizationById($id);

        if(!$item){
            throw new \Exception('Organization cannot be found!');
        }

        $deleteItem = $this->repository->deleteOrganization($id);

        if (!$deleteItem){
            throw new \Exception('Organization failed to remove!');
        }

        return true;
    }
}
