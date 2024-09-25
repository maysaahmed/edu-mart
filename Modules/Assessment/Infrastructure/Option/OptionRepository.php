<?php
namespace Modules\Assessment\Infrastructure\Option;

use Modules\Assessment\Core\Option\Repositories\IOptionRepository;
use App\Infrastructure\Repository\Repository;
use Modules\Assessment\Domain\Entities\Option;
use Illuminate\Support\Collection;

class OptionRepository extends Repository implements IOptionRepository
{
    protected function model(): string
    {
        return Option::class;
    }

    public function getOptions(): Collection
    {
        return Option::select('id', 'text', 'weight')->get();

    }


}
