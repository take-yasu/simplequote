@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <div class="row mb-2">
                <h4>■御見積書登録内容をご確認ください</h4>
            </div>
            <!--見積りヘッダー部-->
            <form action="{{route('create.success')}}" method="post">
                @csrf
            <div class="row">
                <div class="col">
                    <div class="float-right btn-group">
                        <div class="btn-toolbar">
                            <button type="submit" class="btn btn-secondary" name="back" value="1">戻る</button>
                            <button type="submit" class="btn btn-primary" name="regist">登録</button>
                        </div class="btn-toolbar">
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card my-2">
                            <div class="card-header">ご登録内容</div>
                            <div class="card-body">
                                @if(Session::get('denpyou_number'))
                                    <div class="row mb-2">
                                        <div class="col-md-2">
                                            <label>伝票No</label>
                                        </div>
                                        <div class="border-bottom col-md-10">
                                            <p>{{Session::get('denpyou_number')}}</p>
                                            <input type="hidden" name="denpyou_number" value="{{Session::get('denpyou_number')}}" />
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2">
                                            <label>見積作成日</label>
                                        </div>
                                        <div class="border-bottom col-md-10">
                                            <p>{{Session::get('estimated_Date')}}</p>
                                            <input type="hidden" name="estimated_Date" value="{{Session::get('estimated_Date')}}" />
                                        </div>
                                    </div>
                                @endif
                                <div class="row mb-2">
                                    <div class="col-md-2">
                                        <label>お届け先名称</label>
                                    </div>
                                    <div class="border-bottom col-md-10">
                                        <p>{{$request->delivery_name}}</p>
                                        <input type="hidden" name="delivery_name" value="{{$request->delivery_name}}" />
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2">
                                        <label>お届け先ご住所</label>
                                    </div>
                                    <div class="border-bottom col-md-10">
                                        {{$request->zip}}
                                        {{$pref->pref_name}}
                                        {{$request->address02}}
                                        {{$request->address03}}
                                        <input type="hidden" name="zip" value="{{$request->zip}}" />
                                        <input type="hidden" name="address01" value="{{$request->address01}}" />
                                        <input type="hidden" name="address02" value="{{$request->address02}}" />
                                        <input type="hidden" name="address03" value="{{$request->address03}}" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--見積明細部-->
            <div class="container">
                <div class="row">
                    <div class="col">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>品番</th>
                                    <th>品名</th>
                                    <th>数量</th>
                                    <th>単位</th>
                                    <th>単価</th>
                                    <th>小計</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($request->new_product_number as $index => $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item}}<input type="hidden" name="product_number[]" value="{{$item}}" /></td>
                                    <td>{{$request->product_name[$index]}}<input type="hidden" name="product_name[]" value="{{$request->product_name[$index]}}" /></td>
                                    <td>{{$request->quantity[$index]}}<input type="hidden" name="quantity[]" value="{{$request->quantity[$index]}}" /></td>
                                    <td>{{$request->unit[$index]}}<input type="hidden" name="unit[]" value="{{$request->unit[$index]}}" /></td>
                                    <td>{{number_format($request->unit_price[$index])}}円<input type="hidden" name="unit_price[]" value="{{($request->unit_price[$index])}}" /></td>
                                    <td>{{number_format($request->subtotal[$index])}}円<input type="hidden" name="subtotal[]" value="{{($request->subtotal[$index])}}" /></td>
                                </tr>
                                @endforeach
                                @if($request->msg)
                                    <tr>
                                        <td colspan="6" align="right">配送料金</td>
                                        <td class="alert alert-danger">{{$request->msg}}</td>
                                    <tr>
                                @else
                                    <tr>
                                        <td colspan="6" align="right">配送料金</td>
                                        <td>{{number_format($request->fee)}}円</td>
                                    <tr>
                                @endif
                                <tr>
                                    <td colspan="6" align="right">小計</td>
                                    <td>{{number_format($request->subtotals)}}円</td>
                                <tr>
                                <tr>
                                    <td colspan="6" align="right">消費税</td>
                                    <td>{{number_format($request->tax)}}円</td>
                                </tr>
                                <tr>
                                    <td colspan="6" align="right">総計（税込）</td>
                                    <td>{{number_format($request->total)}}円</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection
