<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
        if (isset($this->created_to, $this->created_from)){
            return [
                'created_to' => 'after_or_equal:created_from',
            ];
        }

        return [];
    }

    public function messages(){
        return [
            'created_to.after_or_equal' => '日付が不正です',
        ];
    }

    protected function prepareForValidation(){
        //半角英数に変換
        $denpyou_number = mb_strtoupper(mb_convert_kana($this->denpyou_number, 'rm'));
        $this->denpyou_number = $denpyou_number;

        $product_number = mb_strtoupper(mb_convert_kana($this->product_number, 'rm'));
        $this->product_number = $product_number;
    }
}
