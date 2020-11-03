<?php
namespace App\Library;

use App\CityDistance;
use App\DeliveryFee;

class DeliveryFeeQuote{
    public function calcResult($pref_code, $city_name, $weights){
        $item = CityDistance::where('pref_code', '=', $pref_code)->where('city_name', '=', $city_name)->first(['distance']);
        if (!empty($item->distance)){
            $distance = $item->distance;
            $result = DeliveryFee::where('fromkm', '<=', $distance)
                ->where('tokm', '>=', $distance)
                ->where('fromkg', '<=', $weights)
                ->where('tokg', '>=', $weights)
                ->first(['delivery_fee']);
            $fee = [
                'delivery_fee' => $result->delivery_fee,
                'msg' => '',
            ];
            return $fee;
        }else{
            $fee = [
                'delivery_fee' => '',
                'msg' => 'お届け先住所が存在しません',
            ];
            return $fee;
        }

    }
}
