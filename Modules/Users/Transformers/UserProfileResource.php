<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $path = env('APP_URL').'/images/profile/';
//        dd($this->account);
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email ?? '',
            'dob' => $this->account ? $this->account->date_of_birth : '',
            'gender' => $this->account ? $this->account->gender : '',
            'graduated' => $this->account ? $this->account->graduated : '',
            'education' => $this->account ? $this->account->education : '',
            'university' => $this->account ? $this->account->university : '',
            'industry' => $this->account ? $this->account->industry : '',
            'image' => ($this->account && isset($this->account->image)) ? $path.$this->account->image : $path.'avatar.jpg',

        ];
    }
}