<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Queries\GetUserAssessments;

use Illuminate\Database\Eloquent\Collection;

interface IGetUserAssessments
{
    public function execute(): Collection;
}
