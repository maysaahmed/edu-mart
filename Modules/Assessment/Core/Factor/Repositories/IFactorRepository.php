<?php
namespace Modules\Assessment\Core\Factor\Repositories;

use App\Core\Repository\IRepository;
use Modules\Assessment\Core\Factor\Commands\EditFactor\EditFactorModel;
use Modules\Assessment\Core\Factor\Commands\EditFormula\EditFormulaModel;
use Modules\Assessment\Domain\Entities\Factor;
use Illuminate\Support\Collection;

interface IFactorRepository extends IRepository
{
    public function getFactorById($id): Factor|null;
    public function getFactors(): Collection;
    public function editFactor(EditFactorModel $model): Factor|null;
    public function editFormula(EditFormulaModel $model): bool|null;
}
