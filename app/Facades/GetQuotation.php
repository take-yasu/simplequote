<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class GetQuotation extends Facade{
    protected static function getFacadeAccessor(){
        return 'getquotation';
    }
}
