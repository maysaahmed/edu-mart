<?php

namespace Modules\Assessment\Core\Result\Commands\ICreateResult;


interface ICreateResult
{
    public function execute(Array $answers): bool;
}
