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
            'description' => $this->desc,
            'duration' => $this->duration . 'Hours',
            'price' => $this->price . 'EGP',
            'level' => $this->level ? $this->level->name : '' ,
            'provider' => $this->provider ? $this->provider->name : '',
            'category' => $this->category ? $this->category->name : '',
        ];
    }
}
