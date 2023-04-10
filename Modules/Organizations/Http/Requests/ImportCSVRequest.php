<?php

namespace Modules\Organizations\Http\Requests;
use App\Http\Requests\ApiRequest;

class ImportCSVRequest extends ApiRequest
{
    public function rules():array
    {
        return [
            'file'      => 'required|mimes:csv,txt',
            ];

    }

    public function messages():array
    {

        return [
            'file.required' => 'The file is required.',
            'file.mimes' => 'The file field must be a file of type: csv'
        ];

    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
