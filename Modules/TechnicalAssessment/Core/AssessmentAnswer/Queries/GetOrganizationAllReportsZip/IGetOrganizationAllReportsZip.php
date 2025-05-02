<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Queries\GetOrganizationAllReportsZip;



interface IGetOrganizationAllReportsZip
{
    public function execute(int $org_id): string;
}
