<?php

namespace Modules\Courses\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseFactorResource extends JsonResource
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
            'factor_id' => $this->factor_id,
            'factor' => $this->factor->getTranslation('name', 'en'),
            'result' => $this->result ?? '',
        ];
    }
}
