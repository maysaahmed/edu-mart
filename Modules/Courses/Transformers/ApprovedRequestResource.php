<?php

namespace Modules\Courses\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;


class ApprovedRequestResource extends JsonResource
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
            'user_name' => $this->user->name,
            'course'    => $this->course->title,
            'organization'  => $this->user->organization ? $this->user->organization->name : '',
            'date'    => \Carbon\Carbon::parse($this->updated_at)->format('Y-m-d'),

        ];
    }
}
