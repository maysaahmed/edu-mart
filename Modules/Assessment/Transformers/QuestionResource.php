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
            'ques' => $this->getTranslations('ques', ['en', 'ar']),
            'factor' => $this->factor->getTranslations('name', ['en']),
            'factor_id' => $this->factor_id
        ];
    }
}
