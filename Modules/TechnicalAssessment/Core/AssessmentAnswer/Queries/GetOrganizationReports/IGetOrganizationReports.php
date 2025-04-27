<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Queries\GetOrganizationReports;

use Illuminate\Database\Eloquent\Collection;

interface IGetOrganizationReports
{
    public function execute(int $org_id): Collection;
}
