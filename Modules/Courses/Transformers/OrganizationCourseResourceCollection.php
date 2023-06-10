<?php

namespace Modules\Courses\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrganizationCourseResourceCollection extends ResourceCollection
{

    protected string $org_id;

    public function organization($value)
    {
        $this->org_id = $value;
        return $this;
    }


    public function toArray($request)
    {
        return $this->collection->map(function (OrganizationCourseResource $resource) use ($request) {
            return $resource->organization($this->org_id)->toArray($request);
        })->all();
    }
}
