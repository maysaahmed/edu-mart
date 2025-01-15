<?php

namespace Modules\Courses\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->desc ?? '',
            'duration' => $this->duration,
            'price' => $this->price,
            'level' => $this->level ? $this->level->name : '' ,
            'level_id' => $this->level_id ,
            'level_color' => $this->level ? $this->level->color : '' ,
            'provider' => $this->provider ? $this->provider->name : '',
            'provider_id' => $this->provider_id ,
            'category' => $this->category ? $this->category->name : '',
            'category_id' => $this->category_id ,
            'location' => $this->location ?? '',
            'factors' => CourseFactorResource::collection($this->courseFactors),
        ];
    }
}
