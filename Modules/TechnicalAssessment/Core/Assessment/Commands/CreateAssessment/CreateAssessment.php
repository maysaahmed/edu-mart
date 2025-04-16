<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Commands\CreateAssessment;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;

class CreateAssessment implements ICreateAssessment
{
    private IAssessmentRepository $repository;

    public function __construct(IAssessmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateAssessmentModel $model): Assessment
    {
        return $this->repository->createAssessment($model);
    }
}

