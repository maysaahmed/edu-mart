<?php

namespace Modules\Courses\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationCourseResource extends JsonResource
{
    protected string $org_id;

    public function organization($value)
    {
        $this->org_id = $value;
        return $this;
    }

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
            'duration' => $this->duration,
            'price' => $this->price,
            'level' => $this->level ? $this->level->name : '' ,
            'level_color' => $this->level ? $this->level->color : '' ,
            'provider' => $this->provider ? $this->provider->name : '',
            'visible' => $this->organizations->contains($this->org_id) ? false : true
        ];
    }

    public static function collection($resource){
        return new OrganizationCourseResourceCollection($resource);
    }
}
