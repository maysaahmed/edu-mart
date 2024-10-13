<?php

namespace Modules\Assessment\Http\Requests;
use App\Http\Requests\ApiRequest;

class FormulaRequest extends ApiRequest
{
    /**
     * validation rules
     * @return string[]
     */
    public function rules()
    {
        return [
            'formula' => 'required|string',
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
