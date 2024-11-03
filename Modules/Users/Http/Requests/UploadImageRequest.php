<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;
use Carbon\Carbon;

class UploadImageRequest extends ApiRequest
{
    public function rules()
    {

        return [
            'image' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ];


    }

    public function messages()
    {

        return [
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
