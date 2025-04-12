<?php
namespace Modules\TechnicalAssessment\Core\AssessmentTier\Commands\CreateAssessmentTier;

use Modules\TechnicalAssessment\Core\AssessmentTier\Repositories\IAssessmentTierRepository;
use Modules\TechnicalAssessment\Domain\Entities\AssessmentTier;

class CreateAssessmentTier implements ICreateAssessmentTier
{
    private IAssessmentTierRepository $repository;

    public function __construct(IAssessmentTierRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CreateAssessmentTierModel $model): AssessmentTier
    {
        return $this->repository->createAssessmentTier($model);
    }
}

