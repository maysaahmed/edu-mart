<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
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
            'editor' => $this->editor ? $this->editor->name : '',
            'organization' => $this->organization_name ? $this->organization_name : '',
            'status' => $this->is_active ? 'active' : 'blocked'
        ];
    }
}