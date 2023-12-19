<?php

namespace Modules\Courses\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCourseResourceCollection extends ResourceCollection
{

    protected string $request_status;

    public function status($value)
    {
        $this->request_status= $value;
        return $this;
    }


    public function toArray($request)
    {
        return $this->collection->map(function (UserCourseResource $resource) use ($request) {
            return $resource->status($this->request_status)->toArray($request);
        })->all();
    }
}
