<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MitsumoriHeader;
use App\MitsumoriDetail;

class DetailController extends Controller
{
    public function index($denpyou_number){
        $items = MitsumoriHeader::with('mitsumoriDetails')->where('denpyou_number', '=', $denpyou_number)->first();
        $tax = number_format(round($items->total_sales * config('const.TAX'))) . '円';
        $total = number_format($items->total_sales + ($items->total_sales * config('const.TAX'))) . '円';
        return view('search.detail', ['items' => $items, 'tax' => $tax, 'total' => $total]);
    }
}
