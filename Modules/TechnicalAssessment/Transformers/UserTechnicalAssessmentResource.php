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
        $weights = $this->questions()
            ->select('question_type', \DB::raw('SUM(weight) as total_weight'))
            ->groupBy('question_type')
            ->pluck('total_weight', 'question_type')
            ->toArray();



        return [
            'id' => $this->id,
            'name' => $this->name,
            'desc' => $this->desc,
            'mcq_points' => isset($weights['mcq']) ? (int)$weights['mcq'] : 0,
            'true_false_points' => isset($weights['t/f']) ? (int) $weights['t/f'] : 0,
            'scenario_based_points' => isset($weights['sb']) ? (int) $weights['sb'] : 0,
            'mcq_count' => $this->questions()->where('question_type', 'mcq')->count(),
            'true_false_count' => $this->questions()->where('question_type', 't/f')->count(),
            'scenario_based_count' => $this->questions()->where('question_type', 'sb')->count(),
            'questions' => UserAssessmentQuestionResource::collection($this->questions),

        ];
    }
}
