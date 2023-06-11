<?php
namespace Modules\Courses\Core\Request\Commands\CreateRequest;

use Modules\Courses\Core\Request\Repositories\IRequestRepository;
use Modules\Courses\Domain\Entities\Request;

class CreateRequest implements ICreateRequest
{
    private IRequestRepository $repository;

    public function __construct(IRequestRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateRequestModel $model): Request
    {
        return $this->repository->createRequest($model);
    }
}
