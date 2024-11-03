<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'verified' => $this->check_email_status ? 'Verified' : 'Resend Mail',
            'editor' => $this->editor ? $this->editor->name : '',
            'status' => $this->is_active ? 'active' : 'blocked',
            'took_assessment' => count($this->results) ? true : false
        ];
    }
}
