<?php
namespace Modules\Assessment\Infrastructure\Result;

use Modules\Assessment\Core\Result\Repositories\IResultRepository;
use App\Infrastructure\Repository\Repository;
use Modules\Assessment\Domain\Entities\Result;
use Modules\Assessment\Domain\Entities\Factor;
use DB;

class ResultRepository extends Repository implements IResultRepository
{
    protected function model(): string
    {
        return Result::class;
    }

    private function associativeArray($answers): array
    {
        $associativeArray = [];

        foreach ($answers as $answer) {
            $associativeArray[$answer['id']] = $answer['answer'];
        }

        return $associativeArray;
    }

    public function createResults(Array $answers): bool|null
    {
        // Start a database transaction
        DB::beginTransaction();
        try {
            $factors = Factor::get();
            $associative = $this->associativeArray($answers);

            foreach ($factors as $factor) {
               $formula = $factor->formula;
               $explodedArray = preg_split('/([+-])/', $formula, -1, PREG_SPLIT_DELIM_CAPTURE);
                $actualFormula = '';
                foreach($explodedArray as $index => $value)
                {
                    if($index == 0 || $value == '-' || $value == '+'){
                        $actualFormula .= $value;
                    }else{
                        $actualFormula .= $associative[$value];
                    }
                }
                eval('$result = ' . $actualFormula . ';');

//                Result::create([
//                    'user_id' => auth()->id(),
//                    'factor_id' => $factor->id,
//                    'result' => $result
//                ]);
            }
            die;
            // Commit the transaction
            DB::commit();

            return true;
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();
            return false;
        }

        return null;
    }

}
