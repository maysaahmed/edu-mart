<?php
namespace Modules\Users\Core\User\Commands\UploadProfileImage;

use Modules\Users\Core\User\Repositories\IUserRepository;
use Modules\Users\Domain\Entities\EndUser;
use Modules\Users\Domain\Entities\User;

class UploadProfileImage implements IUploadProfileImage
{
    public function __construct(
        private IUserRepository $repository
    )
    {
    }

    public function execute($id, $image): string
    {
        $item = $this->repository->getUserById($id);

        if(!$item){
            throw new \Exception('User cannot be found!');
        }

        if($id !== auth()->id())
        {
            throw new \Exception('You cann\'t update this data!');
        }

        $uploadedImage = $this->repository->uploadImage($id, $image);
        if ($uploadedImage){
            return $uploadedImage;
        }

        throw new \Exception('Image failed to upload!');
    }
}
