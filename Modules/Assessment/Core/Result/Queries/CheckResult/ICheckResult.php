<?php
namespace Modules\Assessment\Core\Result\Queries\CheckResult;
use Illuminate\Support\Collection;

interface ICheckResult
{
    public function execute(): bool;
}
