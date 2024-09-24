<?php

namespace Modules\Assessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FactorResource extends JsonResource
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
            'name_en' => $this->getTranslation('name', 'en'),
            'name_ar' => $this->getTranslation('name', 'ar'),
            'desc_en' => $this->getTranslation('desc', 'en'),
            'desc_ar' => $this->getTranslation('desc', 'ar'),
            'low_desc_en' => $this->getTranslation('low_desc', 'en'),
            'low_desc_ar' => $this->getTranslation('low_desc', 'ar'),
            'moderate_desc_en' => $this->getTranslation('moderate_desc', 'en'),
            'moderate_desc_ar' => $this->getTranslation('moderate_desc', 'ar'),
            'high_desc_en' => $this->getTranslation('high_desc', 'en'),
            'high_desc_ar' => $this->getTranslation('high_desc', 'ar'),
            'formula' => $this->formula,
            'questions' => QuestionResource::collection($this->questions)


        ];
    }
}
