<?php
namespace Modules\Courses\Core\Request\Commands\ManageRequest;

use Modules\Courses\Core\Request\Repositories\IRequestRepository;

class ManageRequest implements IManageRequest
{
    private IRequestRepository $repository;

    public function __construct(IRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ManageRequestModel $model): bool
    {
        $item =$this->repository->getRequestById($model->id);

        if(!$item){
            throw new \Exception('Request cannot be found!');
        }


        $updated = $this->repository->editRequestStatus($model->id, $model->status, $model->note);

        if ($updated){
            return $updated;
        }

        throw new \Exception('Request status failed to update!');
    }
}
