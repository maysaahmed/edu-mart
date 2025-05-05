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
        $valid = $this->repository->checkAssessmentCode($model->assessment_id, $model->code);

        if(!$valid)
            throw new \Exception('The code you have entered is invalid!');

        //check if user registered with the right official email
        $validEmail = $this->repository->checkUserEmail($model->assessment_id);

        if(!$validEmail)
            throw new \Exception('You need to sign up with your company email to use this code.');


        //check if user take assessment before
        $retakeStatus = $this->repository->canUserRetakeAssessment($model->assessment_id);
        if($retakeStatus == false)
            throw new \Exception("You can't retake the assessment.");

        if ($retakeStatus !== true)
            throw new \Exception("You can retake the assessment in {$retakeStatus} days.");

        //check user limit
        $limitReached = $this->repository->checkUserLimitOrganization($model->assessment_id);

        if($limitReached)
            throw new \Exception('Assessment limit reached.');

        return $this->repository->getAssessmentById($model->assessment_id);
    }
}

