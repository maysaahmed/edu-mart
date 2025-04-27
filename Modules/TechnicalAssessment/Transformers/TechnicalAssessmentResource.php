<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class TechnicalAssessmentResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'desc' => $this->desc,
            'type' => $this->assessment_type,
            'questions' => AssessmentQuestionResource::collection($this->questions),
            'organizations' => AssessmentOrganizationResource::collection($this->organizations),
            'tiers' => AssessmentTierResource::collection($this->tiers)
        ];
    }
}
