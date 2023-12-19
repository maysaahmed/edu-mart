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
        $states = [ 'New', 'Approved', 'Rejected', 'Canceled', 'Booked', 'Rejected'];

        return [
            'id' => $this->id,
            'user_name' => $this->user->name,
            'email' => $this->user->email,
            'course'    => $this->course->title,
            'provider'    => $this->course->provider->name,
            'price'    => $this->course->price,
            'organization'  => $this->user->organization ? $this->user->organization->name : '',
            'status'    => $states[$this->status],
            'note'      => $this->note ?? ''

        ];
    }
}
