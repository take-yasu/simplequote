@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">

            <!-- 検索フォーム -->
            <div class="card mb-2">
                <div class="card-header">検索条件を入力してください</div>
                <div class="card-body">
                    <form action="{{route('search.search')}}" method="get" id="search" name="search">
                        @csrf
                        <!--入力エラーの表示-->
                        @if(count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">{{$error}}</div>
                            @endforeach
                        @endif
                        <div class="form-group row">
                            <label for="denpyou_number" class="col-md-2 col-form-label">伝票番号</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="denpyou_number" name="denpyou_number" placeholder="伝票番号を入力" value="{{ old('denpyou_number') }}">
                            </div>
                            <label for="created" class="col-md-2 col-form-label">見積日付</label>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" id="created_from" name="created_from" value="{{old('created_from')}}">
                                    </div>
                                    ～
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" id="created_to" name="created_to" value="{{old('created_to')}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="delivery_name" class="col-md-2 col-form-label">お届け先名称</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="delivery_name" name="delivery_name" placeholder="お届け先名称を入力" value="{{ old('delivery_name') }}">
                            </div>
                            <label for="address" class="col-md-2 col-form-label">お届け先ご住所</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="address" name="address" placeholder="お届け先ご住所を入力" value="{{ old('address') }}">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="product_number" class="col-md-2 col-form-label">商品コード</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="product_number" name="product_number" value="{{ old('product_number') }}">
                            </div>
                            <label for="product_name" class="col-md-2 col-form-label">商品名称</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="product_name" name="product_name" value="{{ old('product_name') }}">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row form-inline float-right">
                            <button type="submit" class="btn btn-primary mr-2">検索</button>
                            <clear-data></clear-data>
                            <!--<button type="button" id="clear" class="btn btn-secondary" @click="clearData">クリア</button>-->
                        </div>
                    </form>
                </div>
            </div>
            {!! $items->appends(request()->query())->links() !!}
            <!-- 検索結果表示 -->
            @if($header === 1)
            <!--ヘッダ情報のみ表示-->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>見積日付</th>
                        <th>伝票番号</th>
                        <th>お届け先名称</th>
                        <th>お届け先ご住所</th>
                        <th>金額総計</th>
                    </tr>
                <thead>
                <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{$item->estimated_Date}}</td>
                        <td><a href="{{route('detail.index', ['denpyou_number' => $item->denpyou_number])}}">{{$item->denpyou_number}}</a></td>
                        <td>{{$item->delivery_name}}</td>
                        <td>{{$item->all_address}}</td>
                        <td>{{$item->separator_total}}</td>
                    </tr>
                @endforeach
                <tbody>
            </table>
            @else
            <!--ヘッダ＆明細情報表示-->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>見積日付</th>
                        <th>伝票番号</th>
                        <th>お届け先名称</th>
                        <th>お届け先ご住所</th>
                        <th>商品コード</th>
                        <th>商品名称</th>
                        <th>数量</th>
                        <th>小計</th>
                    </tr>
                </thead>
                <tbody class="table-striped">
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->mitsumoriHeader->estimated_Date}}</td>
                            <td><a href="{{route('detail.index', ['denpyou_number' => $item->denpyou_number])}}">{{$item->denpyou_number}}</a></td>
                            <td>{{$item->mitsumoriHeader->delivery_name}}</td>
                            <td>{{$item->mitsumoriHeader->short_address}}</td>
                            <td>{{$item->product_number}}</td>
                            <td>{{$item->product_name}}</td>
                            <td>{{$item->price_and_unit}}</td>
                            <td>{{$item->subtotal}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
@endsection
