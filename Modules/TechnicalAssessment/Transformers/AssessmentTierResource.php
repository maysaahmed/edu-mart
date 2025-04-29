<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentTierResource extends JsonResource
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
            'evaluation' => $this->evaluation,
            'assessment_id' => $this->assessment_id,
            'from' => $this->from,
            'to' => $this->to,
            'desc' => $this->desc ?? '',
            'courses' => AssessmentCourseResource::collection($this->courses),
        ];
    }
}
