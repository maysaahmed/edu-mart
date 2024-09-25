<?php

namespace Modules\Assessment\Core\Question\Commands\ReorderQuestions;


interface IReorderQuestions
{
    public function execute(Array $questions): bool;
}
