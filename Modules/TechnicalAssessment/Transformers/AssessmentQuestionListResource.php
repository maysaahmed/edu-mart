<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentQuestionListResource extends JsonResource
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
            'mcq_questions' => AssessmentQuestionResource::collection($this['mcqQuestions']),
            'tf_questions'  => AssessmentQuestionResource::collection($this['t/fQuestions']),
            'sb_questions'  => AssessmentQuestionResource::collection($this['sbQuestions']),
        ];
    }

}
