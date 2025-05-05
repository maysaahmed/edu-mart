<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentOrganizationResource extends JsonResource
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
            'id' => $this->pivot->id,
            'limit_users' => $this->pivot->limit_users ?? null,
            'assessment_id' => $this->pivot->assessment_id ?? null ,
            'organization_id' => $this->pivot->organization_id ?? null,
            'organization' => $this->name
        ];
    }
}
