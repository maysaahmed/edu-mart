<?php

namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserTechnicalAssessmentResource extends JsonResource
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
            'desc' => $this->desc,
            'mcq_points' => $this->mcq_points,
            'true_false_points' => $this->tf_points,
            'scenario_based_points' => $this->sb_points,
            'mcq_count' => $this->questions()->where('question_type', 'mcq')->count(),
            'true_false_count' => $this->questions()->where('question_type', 't/f')->count(),
            'scenario_based_count' => $this->questions()->where('question_type', 'sb')->count(),
            'questions' => UserAssessmentQuestionResource::collection($this->questions),

        ];
    }
}
