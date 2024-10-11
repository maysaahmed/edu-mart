<?php
namespace Modules\Assessment\Infrastructure\Result;

use Illuminate\Support\Collection;
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

    public function getResults(int $user_id): Collection|null
    {
        return Result::where('user_id', $user_id)->get();
    }

    public function takeAssessment(int $user_id): bool
    {
        $results_count = Result::where('user_id', $user_id)->count();
        return ($results_count > 0) ? 1 : 0;
    }

    public function createResults(Array $answers): Collection|bool
    {
        // Start a database transaction
        DB::beginTransaction();
        try {
            $user_id = auth()->id();
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

                Result::create([
                    'user_id' => $user_id,
                    'factor_id' => $factor->id,
                    'result' => $result
                ]);
            }
            // Commit the transaction
            DB::commit();

            return $this->getResults($user_id);
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            DB::rollback();
            return false;
        }

        return false;
    }

}
