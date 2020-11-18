<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MitsumoriHeader extends Model
{
    protected $guarded = [
        'id',
    ];

    public function mitsumoriDetails(){
        return $this->hasMany('App\MitsumoriDetail', 'denpyou_number', 'denpyou_number');
    }

    public function getAllAddressAttribute(){
        return $this->pref_name . $this->city_name . $this->address;
    }

    public function getShortAddressAttribute(){
        return mb_substr($this->pref_name . $this->city_name . $this->address, 0, 10) . '…';
    }

    public function getSeparatorTotalAttribute(){
        return number_format($this->total_sales) . '円';
    }

}
