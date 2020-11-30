<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MitsumoriHeader;
use App\MitsumoriDetail;
use App\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SearchRequest;

class SearchController extends Controller
{
    public function index(){
        $items = MitsumoriHeader::with('mitsumoriDetails')->paginate(3);
        $header = 1; //初期表示はヘッダーのみの一覧
        return view('search.index', ['items' => $items, 'header' => $header]);
    }

    public function search(SearchRequest $request){
        $request->product_number || $request->product_name ? $header = 2 : $header = 1;

        if($header === 1){
            //ヘッダ情報のみの検索
            $items = MitsumoriHeader::where('denpyou_number', 'like', '%' . $request->denpyou_number . '%')
            ->when(isset($request->created_from), function($query) use ($request){
                return $query->where('estimated_Date', '>=', $request->created_from);
            })
            ->when(isset($request->created_to), function($query) use ($request){
                return $query->where('estimated_Date', '<=', $request->created_to);
            })
            ->where('delivery_name', 'like', '%' . $request->delivery_name . '%')
            ->whereRaw('CONCAT(pref_name, city_name, address) like ?', ['%' . $request->address . '%'])
            ->paginate(3);
        }else{
            //ヘッダ＆明細情報の検索
            $items = MitsumoriDetail::with('MitsumoriHeader')
            ->where('denpyou_number', 'like', '%' . $request->denpyou_number . '%')
            ->when(isset($request->created_from), function($query) use ($request){
                return $query->wherehas('mitsumoriHeader', function($query_add) use ($request){
                    $query_add->where('estimated_Date', '>=', $request->created_from);
                });
            })
            ->when(isset($request->created_to), function($query) use ($request){
                return $query->wherehas('mitsumoriHeader', function($query_add) use ($request){
                    $query_add->where('estimated_Date', '<=', $request->created_to);
                });
            })
            ->wherehas('mitsumoriHeader', function($query) use ($request){
                $query->where('delivery_name', 'like', '%' . $request->delivery_name . '%');
            })
            ->wherehas('mitsumoriHeader', function($query) use ($request){
                $query->whereRaw('CONCAT(pref_name, city_name, address) like ?', ['%' . $request->address . '%']);
            })
            ->where('product_number', 'like', '%' . $request->product_number . '%')
            ->where('product_name', 'like', '%' . $request->product_name . '%')
            ->paginate(3);
        }
        $request->flash();
        return view('search.index', ['items' => $items, 'header' => $header]);
    }
}
