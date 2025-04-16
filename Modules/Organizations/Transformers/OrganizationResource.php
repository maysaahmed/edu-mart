<?php

namespace Modules\Organizations\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
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
            'phone' => $this->phone ?? '-',
            'address' => $this->address ?? '-',
            'status' => $this->status,
            'domain' => $this->domain ?? '-',
            'assessments' => $this->assessments()->count() ? $this->assessments()->count() . ' Assessments' : '-'

        ];
    }
}
