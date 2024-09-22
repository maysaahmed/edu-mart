<?php

namespace Modules\Assessment\Core\Question\Commands\EditQuestion;

use Modules\Assessment\Domain\Entities\Question;

interface IEditQuestion
{
    public function execute(EditQuestionModel $model): Question;
}
