<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Queries\CheckAssessmentEditable;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;

class CheckAssessmentEditable implements ICheckAssessmentEditable
{
    private IAssessmentRepository $repository;

    public function __construct(IAssessmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        return $this->repository->checkAssessmentEditable($id);
    }
}
