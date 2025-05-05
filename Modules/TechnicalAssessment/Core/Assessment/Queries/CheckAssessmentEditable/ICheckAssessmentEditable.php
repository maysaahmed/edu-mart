<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Queries\CheckAssessmentEditable;


interface ICheckAssessmentEditable
{
    public function execute(int $id): bool;
}
