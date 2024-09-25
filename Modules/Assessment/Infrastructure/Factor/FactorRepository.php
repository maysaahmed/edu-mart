<?php
namespace Modules\Assessment\Infrastructure\Factor;


use Modules\Assessment\Core\Factor\Repositories\IFactorRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Support\Collection;
use Modules\Assessment\Domain\Entities\Factor;
use Modules\Assessment\Core\Factor\Commands\EditFactor\EditFactorModel;
use DB;

class FactorRepository extends Repository implements IFactorRepository
{
    protected function model(): string
    {
        return Factor::class;
    }

    public function getFactorById($id): Factor|null
    {
        return Factor::find($id);
    }

    public function editFactor(EditFactorModel $model): Factor|null
    {
        $id = $model->id;
        $factor = $this->getFactorById($id);

        if($factor){

            $factor->name = [
                'en' => $model->name_en,
                'ar' => $model->name_ar
            ];
            $factor->desc = [
                'en' => $model->desc_en,
                'ar' => $model->desc_ar
            ];
            $factor->low_desc = [
                'en' => $model->low_desc_en,
                'ar' => $model->low_desc_ar
            ];
            $factor->moderate_desc = [
                'en' => $model->moderate_desc_en,
                'ar' => $model->moderate_desc_ar
            ];
            $factor->high_desc = [
                'en' => $model->high_desc_en,
                'ar' => $model->high_desc_ar
            ];
            $factor->formula = $model->formula;
            $save = $factor->save();

            if ($save) {
                return $factor;
            }
        }

        return null;
    }


    public function getFactors(): Collection
    {
        return Factor::get();

    }



}
