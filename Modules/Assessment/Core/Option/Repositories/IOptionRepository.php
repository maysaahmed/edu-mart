<?php
namespace Modules\Assessment\Core\Option\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Support\Collection;

interface IOptionRepository extends IRepository
{
    public function getOptions(): Collection;
}
