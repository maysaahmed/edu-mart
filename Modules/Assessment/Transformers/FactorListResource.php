<?php

namespace Modules\Assessment\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class FactorListResource extends JsonResource
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
            'name' => $this->getTranslation('name', 'en'),


        ];
    }
}
