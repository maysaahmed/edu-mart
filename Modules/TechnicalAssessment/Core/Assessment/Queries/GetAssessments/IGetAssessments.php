<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessments;

use Illuminate\Database\Eloquent\Collection;

interface IGetAssessments
{
    public function execute(): Collection;
}
