<?php

namespace Modules\Organizations\Http\Requests;
use App\Http\Requests\ApiRequest;

class CreateOrganizationRequest extends ApiRequest
{
    public function rules()
    {
        $rules = [
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|numeric',
            'address' => 'required|regex:/([- ,\/0-9a-zA-Z]+)/|min:8',
            'status' => 'in:1,0'
            ];

        $id = $this->route('organization');
        if (!isset($id))
        {
            $rules += ['name'=> 'required|unique:organizations|max:255'];
        }else{
            $rules += ['name'=> 'required|max:255|unique:organizations,name,'.$id,];
        }
        return $rules;

    }



    public function messages()
    {

        return [
            'name.required' => 'The name is required.',
            'name.unique' => 'The name has already been taken.',
            'name.max' => 'The name length must not be greater than 255 characters.',
            'phone.regex' => 'The phone format is invalid.',
            'phone.min' => 'The phone must not be less than 10 digits.',
            'address.regex' => 'The address format is invalid.',
            'address.min' => 'The address must not be less than 8 characters.',
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
