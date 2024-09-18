<?php
namespace Modules\Assessment\Core\Option\Queries\GetOptions;
use Illuminate\Support\Collection;

interface IGetOptions
{
    public function execute(): Collection;
}
