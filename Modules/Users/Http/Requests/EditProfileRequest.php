<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;
use Carbon\Carbon;

class EditProfileRequest extends ApiRequest
{
    public function rules()
    {

        $id = request()->user()->id;

        return [
            'name'=> 'required|max:255',
            'email'=> 'required|email|unique:users,email,'.$id.',id,deleted_at,NULL',
            'dob' => 'required|date_format:Y-m-d|before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            'gender' => 'required|in:male,female',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'graduated' => 'required|in:0,1',
            'education' => 'required|max:255',
            'university' => 'required|max:255',
            'industry' => 'required|max:255'

        ];


    }

    public function messages()
    {

        return [
            'dob.date_format' => 'The date of birth field must match the format Y-m-d.',
            'dob.before' => 'The date of birth field must be a date before ' . Carbon::now()->subYears(18)->format('Y-m-d'),
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
