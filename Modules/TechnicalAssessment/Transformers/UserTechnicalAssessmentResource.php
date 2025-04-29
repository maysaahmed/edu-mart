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
            'tf_points' => isset($weights['t/f']) ? (int) $weights['t/f'] : 0,
            'sb_points' => isset($weights['sb']) ? (int) $weights['sb'] : 0,
            'mcq_count' => $this->questions()->where('question_type', 'mcq')->count(),
            'tf_count' => $this->questions()->where('question_type', 't/f')->count(),
            'sb_count' => $this->questions()->where('question_type', 'sb')->count(),
            'mcq_questions' => UserAssessmentQuestionResource::collection($this->questions()->where('question_type', 'mcq')->get()),
            'tf_questions' => UserAssessmentQuestionResource::collection($this->questions()->where('question_type', 't/f')->get()),
            'sb_questions' => UserAssessmentQuestionResource::collection($this->questions()->where('question_type', 'sb')->get()),

        ];
    }
}
