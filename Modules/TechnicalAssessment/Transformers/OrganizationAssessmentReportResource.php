<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Organizations\Domain\Entities\Organization\Organization;

class OrganizationAssessmentReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'assessment_id' => $this->assessment_id,
            'assessment' => $this->assessment->name,
            'report' => $this->report ??  null
        ];
    }
}
