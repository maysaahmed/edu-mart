<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessment;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;

class GetAssessment implements IGetAssessment
{
    private IAssessmentRepository $repository;

    public function __construct(IAssessmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): Assessment|null
    {
        return $this->repository->getAssessmentById($id);
    }
}
