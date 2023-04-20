<?php
namespace Modules\Courses\Core\Level\Queries\GetLevels;
use Illuminate\Support\Collection;

interface IGetLevels
{
    public function execute(): Collection;
}
