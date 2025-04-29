<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAssessmentQuestionResource extends JsonResource
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
            'question_type' => $this->question_type,
            'points'    => $this->weight,
            'answers' => UserQuestionAnswerResource::collection($this->answers),
        ];
    }
}
