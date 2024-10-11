<?php
namespace Modules\Assessment\Core\Result\Repositories;

use App\Core\Repository\IRepository;
use Illuminate\Support\Collection;

interface IResultRepository extends IRepository
{
    public function createResults(Array $answers): Collection|bool;
    public function getResults(int $user_id): Collection|null;
    public function takeAssessment(int $user_id): bool;
}
