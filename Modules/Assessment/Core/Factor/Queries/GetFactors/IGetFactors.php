<?php
namespace Modules\Assessment\Core\Factor\Queries\GetFactors;
use Illuminate\Support\Collection;

interface IGetFactors
{
    public function execute(): Collection;
}
