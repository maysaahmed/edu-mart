<?php
namespace Modules\Courses\Core\Provider\Queries\GetProviders;
use Illuminate\Support\Collection;

interface IGetProviders
{
    public function execute(): Collection;
}
