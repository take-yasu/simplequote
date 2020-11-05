@extends('layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <!--見積詳細メニュー-->
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="float-right btn-group">
                            <div class="btn-toolbar">
                                <a href="" class="btn btn-outline-secondary">修正</a>
                                <a href="" class="btn btn-outline-secondary">複写</a>
                                <a href="/api/mitsumori/pdf/{{$items->denpyou_number}}" class="btn btn-outline-secondary">印刷</a>
                                <a href="{{route('search.index')}}" class="btn btn-outline-secondary">一覧</a>
                                <confirm-msg
                                    :denpyou-data="{{ json_encode([
                                        'number' => $items->denpyou_number, 
                                        ])}}">
                                </confirm-msg>
                            </div class="btn-toolbar">
                        </div>
                    </div>
                </div>
            </div>

            <!--見積りヘッダー部-->
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="card my-2">
                            <div class="card-header">見積伝票番号：{{$items->denpyou_number}}</div>
                            <div class="card-body">
                                <div class="row mb-1">
                                    <div class="border-bottom col-md-5">
                                        <div class="row">
                                            <label class="col-md-4">見積作成日</label>
                                            <p class="col-md-8">{{$items->estimated_Date}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="border-bottom col-md-5">
                                        <div class="row">
                                            <label class="col-md-4">会社名</label>
                                            <p class="col-md-8">{{$items->company_name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="border-bottom col-md-5">
                                        <div class="row">
                                            <label class="col-md-4">修正日時</label>
                                            <p class="col-md-8">{{$items->updated_at}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="border-bottom col-md-5">
                                        <div class="row">
                                            <label class="col-md-4">ご担当者様</label>
                                            <p class="col-md-8">{{$items->user_name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="border-bottom col-md-5">
                                        <div class="row">
                                            <label class="col-md-4">納品先名称</label>
                                            <p class="col-md-8">{{$items->delivery_name}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="border-bottom col-md-5">
                                        <div class="row">
                                            <label class="col-md-4">お電話番号</label>
                                            <p class="col-md-8">{{$items->tel}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                </div>
                                <div class="row mb-1">
                                    <div class="border-bottom col-md-5">
                                        <div class="row">
                                            <label class="col-md-4">納品先ご住所</label>
                                            <p class="col-md-8">{{$items->all_address}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
                                    <div class="border-bottom col-md-5">
                                        <div class="row">
                                            <label class="col-md-4">FAX</label>
                                            <p class="col-md-8">{{$items->fax}}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-1"></div>
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
                                    <th>単価</th>
                                    <th>小計</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items->mitsumoriDetails as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->product_number}}</td>
                                        <td>{{$item->product_name}}</td>
                                        <td>{{$item->quantity}}</td>
                                        <td>{{$item->price_and_unit}}</td>
                                        <td>{{$item->subtotal_and_unit}}</td>
                                    </tr>
                                @endforeach
                                    <tr>
                                        <td colspan="5" align="right">小計</td>
                                        <td>{{$items->separator_total}}</td>
                                    <tr>
                                    <tr>
                                        <td colspan="5" align="right">消費税</td>
                                        <td>{{$tax}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="right">総計（税込）</td>
                                        <td>{{$total}}</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
