<?php

namespace Modules\Courses\Http\Requests;
use App\Http\Requests\ApiRequest;

class BookCourseRequest extends ApiRequest
{
    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {
        return [
            'course_id' => 'required|integer|exists:courses,id,deleted_at,null'
        ];

    }



    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
