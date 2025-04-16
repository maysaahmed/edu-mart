<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessments;

use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;

class GetAssessments implements IGetAssessments
{
    private IAssessmentRepository $repository;

    public function __construct(IAssessmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(): Collection
    {
        return $this->repository->getAssessments();
    }
}
