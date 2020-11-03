<?php
namespace App\Facades;
use Illuminate\Support\Facades\Facade;

class DeliveryFeeQuote extends Facade{
    protected static function getFacadeAccessor(){
        return 'deliveryfeequote';
    }
}
