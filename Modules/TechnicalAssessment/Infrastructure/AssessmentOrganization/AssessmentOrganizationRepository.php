<?php
namespace Modules\TechnicalAssessment\Infrastructure\AssessmentOrganization;

use Modules\Organizations\Domain\Entities\Organization\Organization;
use Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\AssignAssessmentToOrganization\AssignAssessmentToOrganizationModel;
use Modules\TechnicalAssessment\Core\AssessmentOrganization\Commands\UnassignAssessmentFromOrganization\UnassignAssessmentFromOrganizationModel;

use App\Infrastructure\Repository\Repository;

use Modules\TechnicalAssessment\Core\AssessmentOrganization\Repositories\IAssessmentOrganizationRepository;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;
use Modules\TechnicalAssessment\Domain\Entities\OrganizationAssessment;

class AssessmentOrganizationRepository extends Repository implements IAssessmentOrganizationRepository
{
    protected function model(): string
    {
        return OrganizationAssessment::class;
    }

    public function assignAssessmentToOrganization(AssignAssessmentToOrganizationModel $model): bool
    {
        $organization = Organization::findOrFail($model->organization_id);

        $organization->assessments()->syncWithoutDetaching([
            $model->assessment_id => [
                'limit_users' => $model->limit_users,
            ]
        ]);

        return true;

    }

    public function unassignAssessmentFromOrganization(UnassignAssessmentFromOrganizationModel $model): bool
    {
        $organization = Organization::findOrFail($model->organization_id);

        $organization->assessments()->detach($model->assessment_id);

        return true;

    }

    public function checkOrganizationAssigned(int $organization_id, int $assessment_id): bool
    {
        $assessment = Assessment::find($assessment_id);
        $assigned = $assessment->organizations()->where('organization_id', $organization_id)->exists();
        if($assigned)
            return true;
        return false;
    }



}
