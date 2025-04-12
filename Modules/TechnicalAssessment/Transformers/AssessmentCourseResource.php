<?php


namespace Modules\TechnicalAssessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class AssessmentCourseResource extends JsonResource
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
            'course_id' => $this->id,
            'course' => $this->title,
        ];
    }
}
