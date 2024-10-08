<?php
namespace Modules\Assessment\Core\Question\Repositories;

use App\Core\Repository\IRepository;
use Modules\Assessment\Core\Question\Commands\EditQuestion\EditQuestionModel;
use Modules\Assessment\Core\Question\Queries\GetQuestionPagination\GetQuestionPaginationModel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Modules\Assessment\Domain\Entities\Question;
use Illuminate\Support\Collection;

interface IQuestionRepository extends IRepository
{
    public function getQuestionById($id): Question|null;
    public function getQuestionsPagination(GetQuestionPaginationModel $model): LengthAwarePaginator;
    public function getQuestions(): Collection;
    public function editQuestion(EditQuestionModel $model): Question|null;
    public function reorderQuestions(Array $questions): bool|null;
}
