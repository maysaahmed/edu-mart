<?php
namespace Modules\Courses\Core\Request\Commands\CreateRequest;

use Modules\Courses\Core\Request\Repositories\IRequestRepository;
use Modules\Courses\Core\Course\Repositories\ICourseRepository;
use Modules\Courses\Domain\Entities\Request;
use Modules\Users\Core\User\Repositories\IUserRepository;

class CreateRequest implements ICreateRequest
{
    private IRequestRepository $repository;
    private ICourseRepository $courseRepository;
    private IUserRepository $userRepository;

    public function __construct(IRequestRepository $repository, ICourseRepository $courseRepository, IUserRepository $userRepository)
    {
        $this->repository = $repository;
        $this->courseRepository = $courseRepository;
        $this->userRepository = $userRepository;
    }

    public function execute(CreateRequestModel $model): Request
    {
        $courseReq = $this->repository->getRequestByCourseId($model->user_id, $model->course_id);
        $user = $this->userRepository->getUserById($model->user_id);

        //check user organization opened this course
        $courseVisible = $this->courseRepository->checkCourseVisibility($model->course_id, $user->organization_id);

        if(!$courseVisible){
            throw new \Exception('This Course is not available for your organization.');
        }

        //check if user booked this course before
        if($courseReq && $courseReq->status == 0){
            throw new \Exception('You already have a pending request on this course');
        }

        if($courseReq && $courseReq->status == 1){
            throw new \Exception('You already have an approved request on this course');
        }

        return $this->repository->createRequest($model);
    }
}
