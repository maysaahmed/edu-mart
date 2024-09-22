<?php

namespace Modules\Assessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'order' => $this->order,
            'ques_en' => $this->getTranslation('ques', 'en'),
            'ques_ar' => $this->getTranslation('ques', 'ar'),
            'factor' => $this->factor->getTranslation('name', 'en'),
            'factor_id' => $this->factor_id
        ];
    }
}
