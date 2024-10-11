<?php

namespace Modules\Assessment\Core\Result\Commands\CreateResult;


use Illuminate\Support\Collection;

interface ICreateResult
{
    public function execute(Array $answers): Collection|bool;
}
