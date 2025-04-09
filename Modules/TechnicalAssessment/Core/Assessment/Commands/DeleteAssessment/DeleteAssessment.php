<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Commands\DeleteAssessment;

use Modules\TechnicalAssessment\Core\Assessment\Repositories\IAssessmentRepository;


class DeleteAssessment implements IDeleteAssessment
{
    private IAssessmentRepository $repository;

    public function __construct(IAssessmentRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        $item =$this->repository->getAssessmentById($id);

        if(!$item){
            throw new \Exception('Assessment cannot be found!');
        }

        $deleteItem = $this->repository->deleteAssessment($id);

        if (!$deleteItem){
            throw new \Exception('Assessment failed to remove!');
        }

        return true;
    }
}
