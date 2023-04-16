<?php
namespace Modules\Organizations\Core\Organization\Commands\EditOrganization;

use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class EditOrganization implements IEditOrganization
{
    private IOrganizationRepository $repository;

    public function __construct(IOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditOrganizationModel $model): Organization
    {
        $item =$this->repository->getOrganizationById($model->id);

        if(!$item){
            throw new \Exception('Organization cannot be found!');
        }

        $updatedItem = $this->repository->editOrganization($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Organization failed to update!');
    }
}
