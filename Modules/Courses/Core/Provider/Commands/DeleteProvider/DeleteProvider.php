<?php
namespace Modules\Courses\Core\Provider\Commands\DeleteProvider;

use Modules\Courses\Core\Provider\Repositories\IProviderRepository;


class DeleteProvider implements IDeleteProvider
{
    private IProviderRepository $repository;

    public function __construct(IProviderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        $item =$this->repository->getProviderById($id);

        if(!$item){
            throw new \Exception('Provider cannot be found!');
        }

        $deleteItem = $this->repository->deleteProvider($id);

        if (!$deleteItem){
            throw new \Exception('Provider failed to remove!');
        }

        return true;
    }
}
