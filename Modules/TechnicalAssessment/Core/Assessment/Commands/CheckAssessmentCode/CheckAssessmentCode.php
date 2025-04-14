<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Commands\CheckAssessmentCode;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;
use Modules\TechnicalAssessment\Domain\Entities\Assessment;

class CheckAssessmentCode implements ICheckAssessmentCode
{
    private IAssessmentRepository $repository;

    public function __construct(IAssessmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CheckAssessmentCodeModel $model): Assessment
    {
        //check if the assessment has this code
        $valid = $this->repository->checkAssessmentCode($model);

        if(!$valid)
            throw new \Exception('The code you have entered is invalid!');

        //check if user registered with the right official email
        $validEmail = $this->repository->checkUserEmail($model->assessment_id);

        if(!$validEmail)
            throw new \Exception('You need to edit your profile to change you email to your company email to use this code');

        return $this->repository->getAssessmentById($model->assessment_id);
    }
}

