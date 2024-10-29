<?php

namespace Modules\Courses\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Courses\Domain\Entities\Request;

class UserCourseResource extends JsonResource
{

    protected string $request_status;

    public function status($value)
    {
        $this->request_status = $value;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $user_id = $request->user()->id;
        $request = Request::where(['user_id' => $user_id, 'course_id' => $this->id])->latest()->first();

        if($request)
        {
            if($this->request_status == 'all')
            {
                $request_status = match ($request->status) {
                    0 => "Pending Approval" ,
                    1 => "Approved (Pending Booking)" ,
                    2 => "Rejected" ,
                    3 => "Canceled",
                    4 => "Booked"
                };
            }else{
                $request_status = $this->request_status;
            }

        }else{
            $request_status = 'Book';
        }

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->desc ?? '',
            'duration' => $this->duration,
            'price' => $this->price,
            'level' => $this->level ? $this->level->name : '' ,
            'level_id' => $this->level_id ,
            'level_color' => $this->level ? $this->level->color : '' ,
            'provider' => $this->provider ? $this->provider->name : '',
            'provider_id' => $this->provider_id ,
            'category' => $this->category ? $this->category->name : '',
            'category_id' => $this->category_id ,
            'location' => $this->location ?? '',
            'request_status' => $request_status
        ];
    }

    public static function collection($resource){
        return new UserCourseResourceCollection($resource);
    }
}
