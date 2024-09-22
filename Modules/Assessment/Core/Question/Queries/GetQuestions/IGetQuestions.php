<?php
namespace Modules\Assessment\Core\Question\Queries\GetQuestions;
use Illuminate\Support\Collection;

interface IGetQuestions
{
    public function execute(): Collection;
}
