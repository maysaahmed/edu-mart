<?php

namespace Modules\TechnicalAssessment\Core\Assessment\Commands\DeleteAssessment;

interface IDeleteAssessment
{
    public function execute(int $id): bool;
}
