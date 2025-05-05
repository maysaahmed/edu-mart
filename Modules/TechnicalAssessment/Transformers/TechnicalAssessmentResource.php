<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\TechnicalAssessment\Domain\Entities\UserAssessmentResult;

class   TechnicalAssessmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $hasResults = UserAssessmentResult::where('assessment_id', $this->id)
            ->whereNotNull('submitted_at')
            ->exists();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'desc' => $this->desc,
            'type' => $this->assessment_type,
            'retake_days' => $this->retake_days,
            'has_result' => $hasResults,
            'questions' => AssessmentQuestionResource::collection($this->questions),
            'organizations' => AssessmentOrganizationResource::collection($this->organizations),
            'tiers' => AssessmentTierResource::collection($this->tiers)
        ];
    }
}
