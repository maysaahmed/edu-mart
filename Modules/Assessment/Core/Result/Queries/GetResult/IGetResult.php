<?php
namespace Modules\Assessment\Core\Result\Queries\GetResult;
use Illuminate\Support\Collection;

interface IGetResult
{
    public function execute(): Collection;
}
