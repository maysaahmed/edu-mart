<?php
namespace Modules\Users\Core\User\Commands\ImportUser;

use Modules\Users\Core\User\Repositories\IUserRepository;

class ImportUser implements IImportUser
{
    private IUserRepository $repository;

    public function __construct(IUserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function execute(string $file_path): int
    {
        $rowUploaded =  $this->repository->importUsers($file_path);
        if($rowUploaded)
            return $rowUploaded;

        throw new \Exception('User failed to upload!');
    }
}
