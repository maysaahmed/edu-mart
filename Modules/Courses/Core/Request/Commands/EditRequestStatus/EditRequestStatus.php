<?php
namespace Modules\Courses\Core\Request\Commands\EditRequestStatus;

use Modules\Courses\Core\Request\Repositories\IRequestRepository;

class EditRequestStatus implements IEditRequestStatus
{
    private IRequestRepository $repository;

    public function __construct(IRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($id, $status): bool
    {
        $item =$this->repository->getRequestById($id);

        if(!$item){
            throw new \Exception('Request cannot be found!');
        }

        if($item->user->organization_id !=  request()->user()->organization_id){
            throw new \Exception('You are not allowed to change it!');
        }

        $updated = $this->repository->editRequestStatus($id, $status);

        if ($updated){
            return $updated;
        }

        throw new \Exception('Request status failed to update!');
    }
}
