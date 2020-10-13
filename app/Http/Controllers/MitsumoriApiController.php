<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\PriceCode;
use App\User;

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
        $products = Product::where('product_name', 'like', '%' . $product_name . '%')->get(['product_number', 'product_name']);
        return $products;
    }
}
