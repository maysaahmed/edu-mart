<?php
namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\EditAssessmentOrganization;

use Modules\TechnicalAssessment\Core\AssessmentOrganization\Repositories\IAssessmentOrganizationRepository;

class EditAssessmentOrganization implements IEditAssessmentOrganization
{
    private IAssessmentOrganizationRepository $repository;

    public function __construct(IAssessmentOrganizationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(EditAssessmentOrganizationModel $model): bool
    {
        return $this->repository->editAssessmentOrganization($model);
    }
}

