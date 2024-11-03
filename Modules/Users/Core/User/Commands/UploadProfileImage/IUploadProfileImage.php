<?php

namespace Modules\Users\Core\User\Commands\UploadProfileImage;


interface IUploadProfileImage
{
    public function execute($id, $image): string;
}
