<?php

namespace Modules\Assessment\Core\Result\Commands\CreateResult;


interface ICreateResult
{
    public function execute(Array $answers): bool;
}
