<?php

namespace Modules\Courses\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $states = [ 'New', 'Approved', 'Rejected', 'Canceled', 'Booked', 'Rejected'];
        return [
            'id' => $this->id,
            'user_name' => $this->user->name,
            'email'     => $this->user->email,
            'course'    => $this->course->title,
            'provider'  => $this->course->provider ? $this->course->provider->name : '',
            'price'     => $this->course->price,
            'status'    => $states[$this->status],

        ];
    }
}
