<?php

namespace Modules\Assessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class ReorderQuestionsRequest extends ApiRequest
{
    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {
        return [
            'questions' => 'required|array',
            'questions.*.id' => 'required|exists:questions,id',
            'questions.*.order' => 'required|integer|min:1|max:50',
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
