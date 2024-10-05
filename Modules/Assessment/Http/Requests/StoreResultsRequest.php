<?php

namespace Modules\Assessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class StoreResultsRequest extends ApiRequest
{
    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {
        return [
            'answers' => 'required|array|size:50',
            'answers.*.id' => 'required|exists:questions,id',
            'answers.*.answer' => 'required|integer|min:1|max:5',
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
