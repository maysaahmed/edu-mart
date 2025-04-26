<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Queries\GetOrganizationReports;

use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories\IAssessmentAnswerRepository;

class GetOrganizationReports implements IGetOrganizationReports
{
    private IAssessmentAnswerRepository $repository;

    public function __construct(IAssessmentAnswerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($org_id): Collection
    {
        return $this->repository->getOrganizationReports($org_id);
    }
}
