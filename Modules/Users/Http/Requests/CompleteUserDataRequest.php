<?php

namespace Modules\Users\Http\Requests;
use App\Http\Requests\ApiRequest;
use Carbon\Carbon;

class CompleteUserDataRequest extends ApiRequest
{
    public function rules()
    {

        $id = request()->user()->id;

        return [
            'name'=> 'nullable|max:255|unique:users,name,'.$id,
            'jobTitle' => 'nullable|max:255',
            'area' => 'nullable|max:255',
            'DOB' => 'nullable|date_format:Y-m-d|before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            'gender' => 'nullable|in:male,female'

        ];


    }

    public function messages()
    {

        return [
            'DOB.date_format' => 'The date of birth field must match the format Y-m-d.',
            'DOB.before' => 'The date of birth field must be a date before ' . Carbon::now()->subYears(18)->format('Y-m-d'),
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
