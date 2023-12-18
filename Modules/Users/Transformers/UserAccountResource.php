<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserAccountResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email ?? '',
            'organization' => $this->organization ? $this->organization->name : '',
            'status' => $this->is_active ? 'active' : 'blocked',
            'jobTitle' => $this->account ? $this->account->job_title : '',
            'area' => $this->account ? $this->account->area : '',
            'birthDate' => $this->account ? $this->account->date_of_birth : '',
            'gender' => $this->account ? $this->account->gender : '',

        ];
    }
}
