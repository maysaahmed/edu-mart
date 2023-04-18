<?php
namespace Modules\Courses\Core\Provider\Commands\EditProvider;

use Modules\Courses\Core\Provider\Repositories\IProviderRepository;
use Modules\Courses\Domain\Entities\Provider;

class EditProvider implements IEditProvider
{
    private IProviderRepository $repository;

    public function __construct(IProviderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditProviderModel $model): Provider
    {
        $item =$this->repository->getProviderById($model->id);

        if(!$item){
            throw new \Exception('Provider cannot be found!');
        }

        $updatedItem = $this->repository->editProvider($model);
        if ($updatedItem){
            return $updatedItem;
        }

        throw new \Exception('Provider failed to update!');
    }
}
