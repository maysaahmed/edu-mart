<?php

namespace Modules\Assessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        if($this->result <= 24)
        {
            $scale = 'low';
        }elseif ($this->result >= 25 && $this->result <=35)
        {
            $scale = 'moderate';
        }else{
            $scale = 'high';
        }
        return [
            'factor_en' => $this->factor->getTranslation('name', 'en'),
            'factor_ar' => $this->factor->getTranslation('name', 'ar'),
            'desc_en' => $this->factor->getTranslation('desc', 'en'),
            'desc_ar' => $this->factor->getTranslation('desc', 'ar'),
            'score' => $this->result,
            'scale' => $scale,
            'score_desc_en' => $this->factor->getTranslation($scale.'_desc', 'en'),
            'score_desc_ar' => $this->factor->getTranslation($scale.'_desc', 'ar'),

        ];
    }
}
