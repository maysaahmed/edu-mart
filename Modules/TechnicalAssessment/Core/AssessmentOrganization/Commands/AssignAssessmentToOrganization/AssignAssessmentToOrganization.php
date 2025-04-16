<?php
namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\AssignAssessmentToOrganization;

use Modules\TechnicalAssessment\Core\AssessmentOrganization\Repositories\IAssessmentOrganizationRepository;

class AssignAssessmentToOrganization implements IAssignAssessmentToOrganization
{
    private IAssessmentOrganizationRepository $repository;

    public function __construct(IAssessmentOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(AssignAssessmentToOrganizationModel $model): bool
    {
        return $this->repository->assignAssessmentToOrganization($model);
    }
}

