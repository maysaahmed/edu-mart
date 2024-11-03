<?php
namespace Modules\Users\Core\User\Commands\RemoveProfileImage;

use Modules\Users\Core\User\Repositories\IUserRepository;

use Modules\Users\Domain\Entities\User;

class RemoveProfileImage implements IRemoveProfileImage
{
    public function __construct(
        private IUserRepository $repository
    )
    {
    }

    public function execute($id): bool
    {
        $item = $this->repository->getUserById($id);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        if($id !== auth()->id())
        {
            throw new \Exception('You cann\'t update this data!');
        }

        $removed = $this->repository->removeImage($id);
        if ($removed){
            return $removed;
        }

        throw new \Exception('Image failed to removed!');
    }
}
