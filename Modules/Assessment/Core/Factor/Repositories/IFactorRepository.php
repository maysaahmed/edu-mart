<?php
namespace Modules\Assessment\Core\Factor\Repositories;

use App\Core\Repository\IRepository;
use Modules\Assessment\Domain\Entities\Factor;
use Illuminate\Support\Collection;

interface IFactorRepository extends IRepository
{
    public function getFactorById($id): Factor|null;
    public function getFactors(): Collection;
//    public function editQuestion(EditQuestionModel $model): Question|null;
}
