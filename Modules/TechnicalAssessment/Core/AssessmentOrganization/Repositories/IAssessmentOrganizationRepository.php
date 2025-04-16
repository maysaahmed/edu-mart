<?php
namespace Modules\TechnicalAssessment\Core\AssessmentOrganization\Repositories;

use App\Core\Repository\IRepository;
use Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\AssignAssessmentToOrganization\AssignAssessmentToOrganizationModel;
use Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\UnassignAssessmentFromOrganization\UnassignAssessmentFromOrganizationModel;

interface IAssessmentOrganizationRepository extends IRepository
{
    public function assignAssessmentToOrganization(AssignAssessmentToOrganizationModel $model): bool;
    public function unassignAssessmentFromOrganization(UnassignAssessmentFromOrganizationModel $model): bool;

}
