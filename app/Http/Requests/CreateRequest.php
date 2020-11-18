<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\facades\DB;
use App\Facades\DeliveryFeeQuote;

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

    public function messages(){
        return [
            'delivery_name.required' => 'お届け先名称は必須です',
            'zip.required' => '郵便番号は必須です',
            'zip.integer' => '郵便番号は数字のみでご入力ください',
            'zip.digits' => '郵便番号は7桁でご入力ください',
            'address01.required' => '都道府県は必須です',
            'address02.required' => '市区町村は必須です',
            'address03.required' => '丁目番地は必須です',
        ];
    }

    protected function prepareForValidation(){
        //運賃以外で、品番が入力されている明細のみ抽出
        $new_product_number = array_filter($this->product_number, function($value){
            return ($value !== '4' || !isnull($value));
        });
        unset($this->product_number);

        //小計
        $subtotals = 0;
        $weights = 0;
        foreach($new_product_number as $key => $item){
            $subtotals += $this->subtotal[$key];
            $weight = DB::table('products')->where('product_number', '=', $item)->first(['weight']);
            $weights += $weight->weight * $this->quantity[$key];
        }

        $fee = DeliveryFeeQuote::calcResult($this->address01, $this->address02, $weights);
        if(!$fee['msg']){
            $subtotals += $fee['delivery_fee'];
        }

        //消費税
        $tax = round($subtotals * config('const.TAX'));

        //総計
        $total = $subtotals + round($subtotals * config('const.TAX'));

        $this->merge([
            'new_product_number' => $new_product_number,
            'subtotals' => $subtotals,
            'tax' => $tax,
            'total' => $total,
            'weights' => $weights,
            'fee' => $fee['delivery_fee'],
            'msg' => $fee['msg'],
        ]);
    }

}
