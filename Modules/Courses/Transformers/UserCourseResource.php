<?php

namespace Modules\Courses\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Courses\Domain\Entities\Request;

class UserCourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $user_id = $request->user()->id;
        $request = Request::where(['user_id' => $user_id, 'course_id' => $this->id])->first();
        if($request)
        {
            $request_status = match ($request->status) {
                0 => "pending" ,
                1 => "approved" ,
                2 => "rejected" ,
            };
        }else{
            $request_status = 'book';
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->desc ?? '',
            'duration' => $this->duration,
            'price' => $this->price,
            'level' => $this->level ? $this->level->name : '' ,
            'level_color' => $this->level ? $this->level->color : '' ,
            'provider' => $this->provider ? $this->provider->name : '',
            'category' => $this->category ? $this->category->name : '',
            'location' => $this->location ?? '',
            'request_status' => $request_status
        ];
    }
}
