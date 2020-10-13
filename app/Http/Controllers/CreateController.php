<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MitsumoriHeader;
use App\MitsumoriDetail;
use App\Prefecture;
use App\Http\Requests\CreateRequest;


class CreateController extends Controller
{
    public function index(){
        $denpyou_row = 5;
        $prefs = Prefecture::get(['pref_name']);
        return view('create.index', ['denpyou_rows' => $denpyou_row, 'prefs' => $prefs]);
    }

    public function insert(CreateRequest $request){

        return view('create.create', ['request' =>$request]);
    }
}
