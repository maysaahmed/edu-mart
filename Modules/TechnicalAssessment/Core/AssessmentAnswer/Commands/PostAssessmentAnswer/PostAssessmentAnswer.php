<?php
namespace Modules\TechnicalAssessment\Core\AssessmentAnswer\Commands\PostAssessmentAnswer;

use Modules\TechnicalAssessment\Core\AssessmentAnswer\Repositories\IAssessmentAnswerRepository;
use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;

class PostAssessmentAnswer implements IPostAssessmentAnswer
{
    private IAssessmentAnswerRepository $repository;
    private IAssessmentRepository $assessmentRepository;

    public function __construct(IAssessmentAnswerRepository $repository, IAssessmentRepository $assessmentRepository)
    {
        $this->repository = $repository;
        $this->assessmentRepository = $assessmentRepository;
    }

    public function execute(PostAssessmentAnswerModel $model): bool
    {
        //check if the assessment has this code
        $valid = $this->assessmentRepository->checkAssessmentCode($model->assessment_id, $model->code);

        if(!$valid)
            throw new \Exception('The code you have entered is invalid!');

        //check if user registered with the right official email
        $validEmail = $this->assessmentRepository->checkUserEmail($model->assessment_id);

        if(!$validEmail)
            throw new \Exception('You need to sign up with your company email to use this code.');


        //check if user take assessment before
        $retakeStatus = $this->assessmentRepository->canUserRetakeAssessment($model->assessment_id);

        if ($retakeStatus !== true)
            throw new \Exception("You can retake the assessment in {$retakeStatus} days.");

        //check user limit
        $limitReached = $this->assessmentRepository->checkUserLimitOrganization($model->assessment_id);
        if($limitReached)
            throw new \Exception('Assessment limit reached.');

        return $this->repository->postAssessmentAnswers($model);
    }
}

