<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MitsumoriHeader;
use App\MitsumoriDetail;
use App\Prefecture;
use App\Http\Requests\CreateRequest;
use App\Facades\DeliveryFeeQuote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CreateController extends Controller
{
    public function index($denpyou_number = null){
        //$old = $request->session()->get('product');
        //dd($old);
        $prefs = Prefecture::get(['pref_name', 'pref_code']);
        if ($denpyou_number){
            $header = MitsumoriHeader::where('denpyou_number', '=', $denpyou_number)->first();
            $details = MitsumoriDetail::where('denpyou_number', $denpyou_number)->whereNotIn('product_number', ['4'])->get();
            return view('create.index', ['prefs' => $prefs, 'header' => $header, 'details' => $details]);
        }else{
            return view('create.index', ['prefs' => $prefs]);
        }
    }

    public function edit($denpyou_number){
        $header = MitsumoriHeader::where('denpyou_number', '=', $denpyou_number)->first();
        $details = MitsumoriDetail::where('denpyou_number', $denpyou_number)->whereNotIn('product_number', ['4'])->get();
        $prefs = Prefecture::get(['pref_name', 'pref_code']);
        return view('create.edit', ['prefs' => $prefs, 'header' => $header, 'details' => $details]);
    }

    public function insert(CreateRequest $request){
        $prefs = Prefecture::where('pref_code', '=', $request->address01)->first(['pref_name']);
        $product = [];
        foreach($request->new_product_number as $key => $value){
            $product[$key] = array(
                'product_number' => $value,
                'product_name' => $request->product_name[$key],
                'quantity' => $request->quantity[$key],
                'unit' => $request->unit[$key],
                'unit_price' => $request->unit_price[$key],
                'subtotal' => $request->subtotal[$key],
            );
        }

        $product[] = [
            'product_number' => '4',
            'product_name' => '配送料金',
            'quantity' => '1',
            'unit' => '式',
            'unit_price' => $request->fee,
            'subtotal' => $request->fee,
        ];

        $request->session()
            ->put(['delivery_name' => $request->delivery_name,
                  'zip' => $request->zip,
                  'pref_code' => $request->address01,
                  'pref_name' => $prefs->pref_name,
                  'city_name' => $request->address02,
                  'address' => $request->address03,
                  'product' => $product,
                  'fee' => $request->fee,
                  'tax' => $request->tax,
                  'total' => $request->total,
              ]);

        //編集の場合、伝票番号を含める
        if ($request->denpyou_number){
            $request->session()->put(['denpyou_number' => $request->denpyou_number, 'estimated_Date' => $request->estimated_Date]);
        }
        //$request->session()->flash();
        return view('create.confirm', ['request' => $request, 'pref' => $prefs]);
    }

    public function success(Request $request){
        if($request->back){
            return redirect('/mitsumori/create')->withInput($request->all());
        }
        if (Session::get('denpyou_number')){
            $next_denpyou_number = Session::get('denpyou_number');
            $estimated_date = Session::get('estimated_Date');
        }else{
            $max = MitsumoriHeader::max('denpyou_number');
            $next_denpyou_number = ++$max;
            $estimated_date = Carbon::now();
        }
        $i = 1;

        DB::transaction(function() use ($next_denpyou_number, $estimated_date, $i){
            MitsumoriHeader::where('denpyou_number', $next_denpyou_number)->delete();
            MitsumoriDetail::where('denpyou_number', $next_denpyou_number)->delete();
            MitsumoriHeader::create([
                'denpyou_number' => $next_denpyou_number,
                'user_code' => Auth::user()->user_code,
                'user_name' => Auth::user()->name,
                'company_name' => Auth::user()->company_name,
                'tel' => Auth::user()->tel,
                'fax' => Auth::user()->fax,
                'delivery_name' => Session::get('delivery_name'),
                'zip' => Session::get('zip'),
                'pref_code' => Session::get('pref_code'),
                'pref_name' => Session::get('pref_name'),
                'city_name' => Session::get('city_name'),
                'address' => Session::get('address'),
                'total_sales' => Session::get('total'),
                'estimated_Date' => $estimated_date,
            ]);
            foreach(Session::get('product') as $product){
                MitsumoriDetail::create([
                    'denpyou_number' => $next_denpyou_number,
                    'row_number' => $i,
                    'product_number' => $product['product_number'],
                    'product_name' => $product['product_name'],
                    'quantity' => $product['quantity'],
                    'unit' => $product['unit'],
                    'unit_price' => $product['unit_price'],
                    'subtotal' => $product['subtotal'],
                ]);
                $i++;
            }
        });


        $items = MitsumoriHeader::with('mitsumoriDetails')->where('denpyou_number', '=', $next_denpyou_number)->first();
        $tax = number_format(round($items->total_sales * config('const.TAX'))) . '円';
        $total = number_format($items->total_sales + ($items->total_sales * config('const.TAX'))) . '円';
        return view('create.success', ['items' => $items, 'tax' => $tax, 'total' => $total]);
    }
}
