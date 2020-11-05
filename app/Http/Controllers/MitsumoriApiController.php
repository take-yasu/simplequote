<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\PriceCode;
use App\User;
use App\MitsumoriHeader;
use App\MitsumoriDetail;
use App\Facades\GetQuotation;

class MitsumoriApiController extends Controller
{
    //品名検索API
    public function getProcutName($product_number){
        $product_number = Product::where('product_number', $product_number)->first();
        return $product_number;
    }

    //単価検索API
    public function getUnitPrice($user_code, $product_number){
        $unit_price = PriceCode::with('user')
            ->whereHas('user', function($query) use ($user_code){
                $query->where('user_code', '=', $user_code);
            })
            ->where('product_number', $product_number)
            ->first(['unit_price']);
        return $unit_price;
    }

    //品番検索API
    public function getProductNumber($product_name){
        $products = Product::where('product_name', 'like', '%' . $product_name . '%')->get(['product_number', 'product_name', 'unit']);
        return $products;
    }

    //見積書PDF作成API
    public function getQuote($denpyou_number){
        $pdf = GetQuotation::createPdf($denpyou_number);
    }

    //見積書削除API
    public function deleteQuote(Request $request){
        MitsumoriDetail::where('denpyou_number', '=', $request->denpyou_number)->delete();
        MitsumoriHeader::where('denpyou_number', '=', $request->denpyou_number)->delete();
        return response(201);
    }

}
