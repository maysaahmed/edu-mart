<?php
namespace Modules\TechnicalAssessment\Core\AssessmentQuestion\Queries\GetQuestionsByAssessmentIDAndType;

use Illuminate\Database\Eloquent\Collection;
use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;
use Modules\TechnicalAssessment\Core\AssessmentQuestion\Repositories\IAssessmentQuestionRepository;


class GetQuestionsByAssessmentIDAndType implements IGetQuestionsByAssessmentIDAndType
{

    private IAssessmentQuestionRepository $repository;
    private IAssessmentRepository $assessmentRepository;

    public function __construct(IAssessmentQuestionRepository $repository, IAssessmentRepository $assessmentRepository)
    {
        $this->repository = $repository;
        $this->assessmentRepository = $assessmentRepository;
    }

    public function execute(GetQuestionsByAssessmentIDAndTypeModel $model): Collection|null
    {
        $assessment =$this->assessmentRepository->getAssessmentById($model->assessment_id);

        if(!$assessment){
            throw new \Exception('Assessment cannot be found!');
        }

        return $this->repository->getAssessmentQuestionsByType($model);

    }
}
