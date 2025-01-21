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
            'user_name' => $this->user->name ,
            'user_id' => $this->user->id ,
            'email' => $this->user->email ,
            'phone' => ($this->user && $this->user->account) ? $this->user->account->phone : '' ,
            'course'    => $this->course ? $this->course->title : '',
            'provider'    => ($this->course && $this->course->provider) ? $this->course->provider->name : '',
            'price'    => $this->course ? $this->course->price : 0,
            'organization'  =>  $this->user->organization ? $this->user->organization->name : '',
            'status'    => $states[$this->status],
            'note'      => $this->note ?? ''

        ];
    }
}
