<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceCode extends Model
{
    public function user(){
        return $this->belongsTo('App\User', 'price_code', 'price_code');
    }
}
