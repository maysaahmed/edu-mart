<?php
namespace Modules\Assessment\Core\Result\Repositories;

use App\Core\Repository\IRepository;

interface IResultRepository extends IRepository
{
    public function createResults(Array $answers): bool|null;
}
