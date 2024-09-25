<?php

namespace Modules\Assessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class QuestionRequest extends ApiRequest
{
    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {
        return [
            'ques_en' => 'required|max:255',
            'ques_ar' => 'required|max:255',
            'order' => 'required|numeric',
            'factor_id' => 'required|integer|exists:factors,id',
        ];

    }

    public function messages()
    {

        return [
            'factor_id.integer' => 'The type field must be an integer.',
            'factor_id.exists' => 'The selected type is invalid.',

            'ques_ar.required' => 'The arabic field is required.',
            'ques_ar.max' => 'The arabic field must not exceed 255 characters.',

            'ques_en.required' => 'The english field is required.',
            'ques_en.max' => 'The english field must not exceed 255 characters.',


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
