<?php
namespace Modules\Assessment\Infrastructure\Factor;


use Modules\Assessment\Core\Factor\Repositories\IFactorRepository;
use App\Infrastructure\Repository\Repository;
use Illuminate\Support\Collection;
use Modules\Assessment\Domain\Entities\Factor;
//use Modules\Assessment\Core\Factor\Commands\EditQuestion\EditQuestionModel;
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

//    public function editQuestion(EditQuestionModel $model): Question|null
//    {
//        $id = $model->id;
//        $question = $this->getQuestionById($id);
//
//        if($question){
//
//            $question->ques = [
//                'en' => $model->ques_en,
//                'ar' => $model->ques_ar
//            ];
//            $question->order = $model->order;
//            $question->factor_id = $model->factor_id;
//            $save = $question->save();
//
//            if ($save) {
//                return $question;
//            }
//        }
//
//        return null;
//    }


    public function getFactors(): Collection
    {
        return Factor::get();

    }



}
