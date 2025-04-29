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
        $assigned = $this->repository->checkOrganizationAssigned($model->organization_id, $model->assessment_id);
        if($assigned)
            throw new \Exception('The organization is already assigned to this assessment!');

        return $this->repository->assignAssessmentToOrganization($model);
    }
}

