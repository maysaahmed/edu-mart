<?php

namespace Modules\Courses\Http\Requests;
use App\Http\Requests\ApiRequest;

class ProviderRequest extends ApiRequest
{
    public function rules()
    {
        $rules = [];
        if (!isset($id))
        {
            $rules += ['name'=> 'required|unique:providers|max:255'];
        }else{
            $rules += ['name'=> 'required|max:255|unique:providers,name,'.$id,];
        }
        return $rules;

    }



    public function messages()
    {

        return [
            'name.required' => 'The name is required.',
            'name.max' => 'The name length must not be greater than 255 characters.',
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
