<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'delivery_name' => 'required',
            'zip' => 'required|integer|digits:7',
            'address01' => 'required',
            'address02' => 'required',
            'address03' => 'required',
        ];
    }

    protected function prepareForValidation(){
        foreach($this->product_number as $index => $item){
            if (empty($item)){
                array_splice($this->product_number, $index, 1);
                array_splice($this->product_name, $index, 1);
            }
        }
    }

}
