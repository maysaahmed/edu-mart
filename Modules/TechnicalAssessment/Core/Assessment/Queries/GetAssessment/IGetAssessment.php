<?php
namespace Modules\TechnicalAssessment\Core\Assessment\Queries\GetAssessment;

use Modules\TechnicalAssessment\Domain\Entities\Assessment;

interface IGetAssessment
{
    public function execute(int $id): Assessment|null;
}
