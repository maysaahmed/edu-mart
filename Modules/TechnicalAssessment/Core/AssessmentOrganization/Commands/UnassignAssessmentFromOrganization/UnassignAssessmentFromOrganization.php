<?php
namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\UnassignAssessmentFromOrganization;

use Modules\TechnicalAssessment\Core\AssessmentOrganization\Repositories\IAssessmentOrganizationRepository;

class UnassignAssessmentFromOrganization implements IUnassignAssessmentFromOrganization
{
    private IAssessmentOrganizationRepository $repository;

    public function __construct(IAssessmentOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(UnassignAssessmentFromOrganizationModel $model): bool
    {
        return $this->repository->unassignAssessmentFromOrganization($model);
    }
}

