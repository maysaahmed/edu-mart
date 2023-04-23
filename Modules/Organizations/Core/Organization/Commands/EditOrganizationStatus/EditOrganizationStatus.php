<?php
namespace Modules\Organizations\Core\Organization\Commands\EditOrganizationStatus;

use Modules\Organizations\Core\Organization\Repositories\IOrganizationRepository;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class EditOrganizationStatus implements IEditOrganizationStatus
{
    private IOrganizationRepository $repository;

    public function __construct(IOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditOrganizationStatusModel $model): Organization
    {
        $item =$this->repository->getOrganizationById($model->id);

        if(!$item){
            throw new \Exception('Organization cannot be found!');
        }

        $updatedItem = $this->repository->editOrganizationStatus($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Organization Status failed to update!');
    }
}
