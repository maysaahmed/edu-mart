<?php
namespace Modules\Courses\Core\Category\Queries\GetCategories;
use Illuminate\Support\Collection;

interface IGetCategories
{
    public function execute(): Collection;
}
