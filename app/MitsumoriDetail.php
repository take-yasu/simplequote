<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MitsumoriDetail extends Model
{
    protected $guarded = [
        'id',
    ];

    public function mitsumoriHeader(){
        return $this->belongsTo('App\MitsumoriHeader', 'denpyou_number', 'denpyou_number');
    }

    public function getPriceAndUnitAttribute(){
        return number_format($this->unit_price) . '円';
    }

    public function getSubtotalAndUnitAttribute(){
        return number_format($this->subtotal) . '円';
    }
}
