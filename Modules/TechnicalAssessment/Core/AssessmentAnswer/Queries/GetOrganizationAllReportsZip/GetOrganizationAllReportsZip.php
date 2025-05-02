<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Queries\GetOrganizationAllReportsZip;

use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories\IAssessmentAnswerRepository;

class GetOrganizationAllReportsZip implements IGetOrganizationAllReportsZip
{
    private IAssessmentAnswerRepository $repository;

    public function __construct(IAssessmentAnswerRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute($org_id): string
    {
        $filePath = $this->repository->getOrganizationReportsZip($org_id);
        if($filePath)
            return $filePath;
        else
            throw new \Exception('Could not create zip file.!');
    }
}
