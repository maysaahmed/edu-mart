<?php
namespace Modules\Assessment\Core\Option\Queries\GetOptions;

use Modules\Assessment\Core\Option\Repositories\IOptionRepository;
use Illuminate\Support\Collection;

class GetOptions implements IGetOptions
{
    private IOptionRepository $repository;

    public function __construct(IOptionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getOptions();
    }
}
