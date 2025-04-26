<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentQuestionResource extends JsonResource
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
            'question' => $this->ques,
            'assessment_id' => $this->assessment_id,
            'question_type' => $this->question_type,
            'weight' => $this->weight,
            'answers' => QuestionAnswerResource::collection($this->answers),
        ];
    }
}
