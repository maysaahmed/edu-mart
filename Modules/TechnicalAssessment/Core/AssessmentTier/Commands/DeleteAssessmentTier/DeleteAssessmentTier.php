<?php
namespace Modules\TechnicalAssessment\Core\AssessmentTier\Commands\DeleteAssessmentTier;

use Modules\TechnicalAssessment\Core\AssessmentTier\Repositories\IAssessmentTierRepository;


class DeleteAssessmentTier implements IDeleteAssessmentTier
{
    private IAssessmentTierRepository $repository;

    public function __construct(IAssessmentTierRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(int $id): bool
    {
        $item =$this->repository->getAssessmentTierById($id);

        if(!$item){
            throw new \Exception('Tier cannot be found!');
        }

        $deleteItem = $this->repository->deleteAssessmentTier($id);

        if (!$deleteItem){
            throw new \Exception('Tier failed to remove!');
        }

        return true;
    }
}
